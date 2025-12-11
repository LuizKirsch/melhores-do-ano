<?php

namespace App\Livewire\Admin;

use App\Models\Alternative;
use App\Models\Option;
use Livewire\Component;

class Winners extends Component
{
    protected $layout = 'components.layouts.app';

    public $currentSlide = 0;
    public $alternatives = [];
    public $totalSlides = 0;
    public $showWinner = false; // Para controlar a revelação

    public function mount()
    {
        $this->loadAlternatives();
    }

    public function loadAlternatives()
    {
        // Buscar alternativas que tenham opções com votos
        $this->alternatives = Alternative::with(['options' => function($query) {
            $query->withCount('userVotes')
                  ->orderBy('user_votes_count', 'desc');
        }])
        ->whereHas('options.userVotes')
        ->get()
        ->map(function($alternative) {
            // Pegar apenas a opção vencedora (com mais votos)
            $winner = $alternative->options->first();
            return [
                'id' => $alternative->id,
                'title' => $alternative->title,
                'winner' => [
                    'id' => $winner->id,
                    'name' => $winner->name,
                    'photo' => $winner->photo,
                    'votes' => $winner->user_votes_count,
                    'total_votes' => $alternative->options->sum('user_votes_count')
                ]
            ];
        })
        ->toArray();

        $this->totalSlides = count($this->alternatives);
    }

    public function nextSlide()
    {
        if ($this->currentSlide < $this->totalSlides - 1) {
            $this->currentSlide++;
            $this->showWinner = false; // Resetar revelação no novo slide
        } else {
            $this->currentSlide = 0; // Volta para o primeiro
            $this->showWinner = false;
        }
    }

    public function prevSlide()
    {
        if ($this->currentSlide > 0) {
            $this->currentSlide--;
            $this->showWinner = false; // Resetar revelação no novo slide
        } else {
            $this->currentSlide = $this->totalSlides - 1; // Vai para o último
            $this->showWinner = false;
        }
    }

    public function goToSlide($index)
    {
        if ($index >= 0 && $index < $this->totalSlides) {
            $this->currentSlide = $index;
            $this->showWinner = false; // Resetar revelação
        }
    }

    public function revealWinner()
    {
        $this->showWinner = true;
    }

    public function render()
    {
        return view('livewire.admin.winners')
            ->with(['title' => 'Apresentação dos Vencedores']);
    }
}
