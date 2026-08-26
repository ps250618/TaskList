<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class TaskView extends Component
{
    #[\Livewire\Attributes\Validate('required')]
    public Task $task;

    public $statuses = [];

    public $priorities = [];

    public $due_dates = [];

    public $assignee_ids = [];

    public $assignees = [];

    public function refreshProjects()
    {
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $this->statuses[$task->id] = $task->status;
            $this->due_dates[$task->id] = $task->due_date?->format('Y-m-d');
            $this->priorities[$task->id] = $task->priority;
            $this->assignee_ids[$task->id] = $task->assignee_id;
        }
    }

    public function updateAssignee($taskId)
    {
        $this->validate([
            "assignee_ids.$taskId" => 'nullable|exists:users,id',
        ]);

        $value = $this->assignee_ids[$taskId] ?? null;

        if ($value === '') {
            $value = null;
        }

        $task = Task::findOrFail($taskId);
        $this->authorize('update', $task);
        $task->update(['assignee_id' => $value]);

        $this->assignee_ids[$taskId] = $task->assignee_id;

        $this->refreshProjects();

        $this->dispatch('task-saved', $task->id);
    }

    public function updateDate($taskId)
    {
        $this->validate([
            "due_dates.$taskId" => 'required|date',
        ]);

        $value = $this->due_dates[$taskId] ?? null;
        $task = Task::findOrFail($taskId);
        $this->authorize('update', $task);
        $task->update(['due_date' => $value]);

        $this->due_dates[$taskId] = $task->due_date;
        $this->refreshProjects();
    }

    public function updatePriority($taskId)
    {
        $this->validate([
            "priorities.$taskId" => 'required',
        ]);

        $value = $this->priorities[$taskId] ?? null;
        $task = Task::findOrFail($taskId);
        $this->authorize('update', $task);
        $task->update(['priority' => $value]);

        $this->priorities[$taskId] = $task->priority;
        $this->refreshProjects();
    }

    public function updateStatus($taskId)
    {
        $this->validate([
            "statuses.$taskId" => 'required',
        ]);

        $value = $this->statuses[$taskId] ?? null;
        $task = Task::findOrFail($taskId);
        $this->authorize('update', $task);
        $task->update(['status' => $value]);

        $this->statuses[$taskId] = $task->status;
        $this->refreshProjects();
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->hasRole('member')) {
            $this->assignees = User::where('id', $user->id)->get();
        } elseif ($user->hasRole('manager')) {
            $this->assignees = User::where('team_id', $user->team_id)->get();
        } else {
            $this->assignees = User::all();
        }

        if (isset($this->task) && $this->task->id) {
            $this->assignee_ids[$this->task->id] = $this->task->assignee_id;
        }

        return view('livewire.task-view', [
            'tags' => Tag::all(),
            'assignees' => $this->assignees,
        ]);
    }
}
