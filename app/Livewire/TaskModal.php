<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class TaskModal extends ModalComponent
{
    #[validate('required')]
    public $title = '';

    #[validate('required')]
    public $description = '';

    #[validate('required')]
    public $status = '';

    #[validate('required')]
    public $priority = '';

    #[validate('required|date')]
    public $dueDate = null;

    #[validate('required|integer|exists:projects,id')]
    public $projectId = null;

    #[validate('nullable|integer|exists:users,id')]
    public $assigneeId = null;

    #[validate('nullable|integer')]
    public $estimateMinutes = null;

    public $Teams = [];

    public function save()
    {
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->dueDate,
            'project_id' => $this->projectId,
            'assignee_id' => $this->assigneeId,
            'estimate_minutes' => $this->estimateMinutes,
        ]);

        $this->dispatch('closeModal');
        $this->dispatch('task-saved');
    }

    public function render()
    {
        $user = auth()->user();

        $projects = \App\Models\Project::query()
            ->when($user->hasRole('manager'), fn ($q) => $q->where('team_id', $user->team_id))->get();
        $users = \App\Models\User::query()
            ->when($user->hasRole('manager'), fn ($q) => $q->where('team_id', $user->team_id))->get();

        return view('livewire.task-modal', [
            'projects' => $projects,
            'users' => $users,
        ]);
    }
}
