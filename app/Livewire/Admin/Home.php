<?php

namespace App\Livewire\Admin;

use App\Models\Alternative;
use App\Models\Option;
use Livewire\Component;
use Livewire\WithFileUploads;

class Home extends Component
{
    use WithFileUploads;

    protected $layout = 'components.layouts.app';

    public $alternatives;
    public $title = '';
    public $optionName = '';
    public $optionPhoto;
    public $selectedAlternativeId;
    public $showModal = false;

    public function mount()
    {
        $this->loadAlternatives();
    }

    public function loadAlternatives()
    {
        $this->alternatives = Alternative::with('options')->get();
    }

    public function createAlternative()
    {
        $this->validate(['title' => 'required|min:3']);

        Alternative::create([
            'title' => $this->title,
            'active' => false  // Criar como inativa por padrão
        ]);
        $this->title = '';
        $this->loadAlternatives();
    }

    public function openModal($alternativeId)
    {
        $this->selectedAlternativeId = $alternativeId;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->optionName = '';
        $this->optionPhoto = null;
    }

    public function addOption()
    {
        $this->validate([
            'optionName' => 'required|min:2',
            'optionPhoto' => 'nullable|image|max:2048'
        ]);

        $photoPath = null;
        if ($this->optionPhoto) {
            $photoPath = $this->optionPhoto->store('options', 'public');
        }

        Option::create([
            'alternative_id' => $this->selectedAlternativeId,
            'name' => $this->optionName,
            'photo' => $photoPath
        ]);

        $this->closeModal();
        $this->loadAlternatives();
    }

    public function deleteOption($optionId)
    {
        Option::find($optionId)->delete();
        $this->loadAlternatives();
    }

    public function deleteAlternative($alternativeId)
    {
        Alternative::find($alternativeId)->delete();
        $this->loadAlternatives();
    }

    public function toggleAlternativeStatus($alternativeId)
    {
        $alternative = Alternative::find($alternativeId);
        $alternative->active = !$alternative->active;
        $alternative->save();
        $this->loadAlternatives();
    }

    public function render()
    {
        return view('livewire.admin.home')
            ->with(['title' => 'Admin Dashboard']);
    }
}
