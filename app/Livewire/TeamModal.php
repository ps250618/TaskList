<?php

namespace App\Livewire;

use App\Models\Team;
use LivewireUI\Modal\ModalComponent;

class TeamModal extends ModalComponent
{
    #[\Livewire\Attributes\Validate('required')]
    public $name = '';

    public function save()
    {
        $this->validate();

        Team::create(['name' => $this->name]);

        $this->dispatch('closeModal');
        $this->dispatch('team-saved');
    }

    public function render()
    {
        return view('livewire.team-modal');
    }
}
