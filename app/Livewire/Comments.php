<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comments extends Component
{
    public Task $task;

    public $newComment = '';

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:2000',
        ]);

        Comment::create([
            'task_id' => $this->task->id,
            'user_id' => Auth::id(),
            'body' => $this->newComment,
        ]);

        $this->newComment = '';
        $this->dispatch('comments-updated', $this->task->id);
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->task->comments()->with('user')->latest()->get(),
        ]);
    }
}
