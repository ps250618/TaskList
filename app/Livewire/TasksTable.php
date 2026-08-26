<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TasksTable extends Component
{
    public $tasks = [];

    public $titles = [];

    public $descriptions = [];

    public $sortDirection = 'asc';

    public $sortField = 'id';

    protected $listeners = ['task-updated' => '$refresh', 'filters-changed' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->dispatch('sort-changed', field: $this->sortField, direction: $this->sortDirection);
    }

    public function updateTitle($taskId, $newTitle)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['title' => $newTitle]);
        $this->dispatch('task-updated');
    }

    public function updateDescription($taskId, $newDescription)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['description' => $newDescription]);
        $this->dispatch('task-updated');
    }

    public function render()
    {
        $this->titles = [];
        $this->descriptions = [];
        foreach ($this->tasks as $task) {
            $this->titles[$task['id']] = $task['title'] ?? '';
            $this->descriptions[$task['id']] = $task['description'] ?? '';
        }

        return view('livewire.tasks-table', [
            'tasks' => $this->tasks,
        ]);
    }
}
