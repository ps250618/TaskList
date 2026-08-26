<?php

namespace App\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TeamsIndex extends Component
{
    #[validate('required')]
    public $teams;

    public $names = [];

    public $showModal = false;

    protected $listeners = ['team-saved' => 'refreshTeams'];

    public function openModal($teamId = null)
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function mount()
    {
        $this->refreshTeams();
    }

    public function refreshTeams()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $this->teams = Team::all();
        } else {
            $this->teams = Team::where('id', $user->team_id)->get();
        }
    }

    public function updateTeam($value, $teamId)
    {
        $this->names[$teamId] = $value;
        $this->validate([
            "names.$teamId" => 'required',
        ]);

        $team = Team::findOrFail($teamId);
        $this->authorize('update', $team);
        $team->update(['name' => $this->names[$teamId]]);
    }

    public function render()
    {
        $teams = Team::all();

        foreach ($teams as $team) {
            $this->names[$team->id] = $team->name;
        }

        return view('livewire.teams-index', [
            'teams' => $teams,
        ]);
    }
}
