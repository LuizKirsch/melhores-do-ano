<?php

namespace App\Livewire\Public;

use App\Models\Alternative;
use App\Models\Vote as VoteModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Vote extends Component
{
    protected $layout = 'components.layouts.app';

    public $activeAlternative;
    public $selectedOptionId;
    public $hasVoted = false;
    public $userVote;

    public function mount()
    {
        $this->loadActiveAlternative();
        $this->checkIfUserVoted();
    }

    public function loadActiveAlternative()
    {
        $this->activeAlternative = Alternative::with(['options', 'votes'])
            ->where('active', true)
            ->first();
    }

    public function checkIfUserVoted()
    {
        if ($this->activeAlternative) {
            $this->hasVoted = Auth::user()->hasVotedFor($this->activeAlternative->id);
            if ($this->hasVoted) {
                $this->userVote = VoteModel::where('user_id', Auth::id())
                    ->where('alternative_id', $this->activeAlternative->id)
                    ->with('option')
                    ->first();
            }
        }
    }

    public function vote()
    {
        if (!$this->selectedOptionId) {
            session()->flash('error', 'Por favor, selecione uma opção para votar.');
            return;
        }

        if (!$this->activeAlternative) {
            session()->flash('error', 'Não há alternativa ativa para votação no momento.');
            return;
        }

        if ($this->hasVoted) {
            session()->flash('error', 'Você já votou nesta alternativa.');
            return;
        }

        try {
            VoteModel::create([
                'user_id' => Auth::id(),
                'alternative_id' => $this->activeAlternative->id,
                'option_id' => $this->selectedOptionId
            ]);

            session()->flash('success', 'Seu voto foi registrado com sucesso!');
            $this->checkIfUserVoted();
            $this->loadActiveAlternative();
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao registrar o voto. Tente novamente.');
        }
    }

    public function render()
    {
        return view('livewire.public.vote');
    }
}
