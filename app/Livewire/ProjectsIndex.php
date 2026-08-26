<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Team;
use Livewire\Component;

class ProjectsIndex extends Component
{
    public $names = [];

    public $descriptions = [];

    public $statuses = [];

    public $codes = [];

    public $teams = [];

    public $teamIds = [];

    public $projects;

    public $showModal = false;

    protected $listeners = ['project-saved' => 'refreshProjects'];

    public function mount()
    {
        $this->refreshProjects();
    }

    public function openModal($projectId = null)
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function refreshProjects()
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            $this->projects = Project::all();
        } else {
            $this->projects = Project::where('team_id', $user->team_id)->get();
        }
    }

    public function updateNames($projectId)
    {
        $this->validate([
            "names.$projectId" => 'required',
        ]);

        $value = $this->names[$projectId] ?? null;
        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project);
        $project->update(['name' => $value]);

        $this->names[$projectId] = $project->name;
        $this->refreshProjects();
    }

    public function updateDescriptions($projectId)
    {
        $this->validate([
            "descriptions.$projectId" => 'required',
        ]);

        $value = $this->descriptions[$projectId] ?? null;
        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project);
        $project->update(['description' => $value]);

        $this->descriptions[$projectId] = $project->description;
        $this->refreshProjects();
    }

    public function updateStatuses($projectId)
    {
        $this->validate([
            "statuses.$projectId" => 'required',
        ]);

        $value = $this->statuses[$projectId] ?? null;
        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project);
        $project->update(['status' => $value]);

        $this->statuses[$projectId] = $project->status;
        $this->refreshProjects();
    }

    public function updateCodes($projectId)
    {
        $this->validate([
            "codes.$projectId" => 'required',
        ]);

        $value = $this->codes[$projectId] ?? null;
        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project);
        $project->update(['code' => $value]);

        $this->codes[$projectId] = $project->code;
        $this->refreshProjects();
    }

    public function updateTeamIds($projectId)
    {
        $this->validate([
            "teamIds.$projectId" => 'required',
        ]);

        $value = $this->teamIds[$projectId] ?? null;
        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project);
        $project->update(['team_id' => $value]);

        $this->teamIds[$projectId] = $project->team_id;
        $this->refreshProjects();
    }

    public function softDeleteProject($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();
        $this->refreshProjects();
    }

    public function render()
    {
        $this->teams = Team::all();

        if (empty($this->projects)) {
            $this->refreshProjects();
        }

        foreach ($this->projects as $project) {
            $this->names[$project->id] = $project->name;
            $this->descriptions[$project->id] = $project->description;
            $this->statuses[$project->id] = $project->status;
            $this->codes[$project->id] = $project->code;
            $this->teamIds[$project->id] = $project->team_id;
        }

        return view('livewire.projects-index', [
            'projects' => $this->projects,
        ]);
    }
}
