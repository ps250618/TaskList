<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class ProjectModal extends ModalComponent
{
    #[validate('required')]
    public $name = '';

    #[validate('required')]
    public $description = '';

    #[validate('required')]
    public $status = '';

    #[validate('required|integer')]
    public $code = '';

    #[validate('required|integer|exists:teams,id')]
    public $teamId = null;

    public $Teams = [];

    public function save()
    {
        $this->validate();

        Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'code' => $this->code,
            'status' => $this->status,
            'team_id' => $this->teamId,
        ]);

        $this->dispatch('closeModal');
        $this->dispatch('project-saved');
    }

    public function render()
    {
        $this->Teams = \App\Models\Team::all();

        return view('livewire.project-modal', [
            'teams' => $this->Teams,
        ]);
    }
}
