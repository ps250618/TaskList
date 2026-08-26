<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Task;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[AllowDynamicProperties]
class TasksIndex extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public $filterStatus = '';

    public $filterPriority = '';

    public $filterProject = '';

    public $filterDue = '';

    public $statuses = ['todo', 'doing', 'done', 'blocked'];

    public $priorities = ['low', 'medium', 'high'];

    public $dueOptions = ['overdue', 'today', 'this_week'];

    public $showModal = false;

    public $sortField = 'due_date';

    public $sortDirection = 'asc';

    protected $listeners = ['task-saved' => '$refresh', 'sort-changed' => 'updateSort'];

    public function updateSort($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
        $this->resetPage();
    }

    public function openModal($taskId = null)
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function render()
    {
        $user = auth()->user();

        // search bar
        $query = Task::with(['assignee', 'project'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            // filters
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterPriority, fn ($q) => $q->where('priority', $this->filterPriority))
            ->when($this->filterProject, fn ($q) => $q->where('project_id', $this->filterProject))
            ->when($this->filterDue, function ($q) {
                $today = now()->startOfDay();
                if ($this->filterDue === 'overdue') {
                    $q->where('due_date', '<', $today);
                } elseif ($this->filterDue === 'today') {
                    $q->whereDate('due_date', $today);
                } elseif ($this->filterDue === 'this_week') {
                    $q->whereBetween('due_date', [$today, $today->copy()->endOfWeek()]);
                }
            });

        if ($user->hasRole('member')) {
            $query->where('assignee_id', $user->id);
        } elseif ($user->hasRole('manager')) {
            $query->whereHas('project.team', fn ($t) => $t->where('id', $user->team_id))
                ->where(function ($q) use ($user) {
                    $q->whereNull('assignee_id')
                        ->orWhereHas('assignee', fn ($a) => $a->where('team_id', $user->team_id));
                });
        }

        $tasks = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $projects = \App\Models\Project::query()
            ->when($user->hasRole('manager'), fn ($q) => $q->where('team_id', $user->team_id))->get();

        return view('livewire.tasks-index', [
            'tasks' => $tasks,
            'projects' => $projects,
        ]);
    }
}
