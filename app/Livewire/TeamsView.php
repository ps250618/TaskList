<?php

namespace App\Livewire;

use App\Models\Team;
use Livewire\Component;

class TeamsView extends Component
{
    public Team $team;

    public function render()
    {
        return view('livewire.teams-view');
    }
}
