<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectView extends Component
{
    public Project $project;

    public function render()
    {
        return view('livewire.project-view');
    }
}
