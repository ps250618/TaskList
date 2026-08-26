<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class TaskTags extends Component
{
    use AuthorizesRequests;

    public Task $task;

    public $selectedTagId;

    public $availableTags = [];

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->availableTags = Tag::all();
    }

    public function attachTag()
    {
        $this->validate([
            'selectedTagId' => 'required|exists:tags,id',
        ]);

        $this->authorize('update', $this->task);

        $this->task->tags()->syncWithoutDetaching([$this->selectedTagId => ['added_by' => auth()->id(),
            'added_at' => now()]]);
        $this->task->refresh();

        $this->selectedTagId = null;
        $this->availableTags = Tag::all();

        $this->dispatch('task-tags-updated', $this->task->id);
    }

    public function detachTag($tagId)
    {
        $this->authorize('update', $this->task);

        $this->task->tags()->detach($tagId);
        $this->task->refresh();
        $this->availableTags = Tag::all();

        $this->dispatch('task-tags-updated', $this->task->id);
    }

    public function render()
    {
        $attached = $this->task->tags()->get();

        $userIds = $attached->pluck('pivot.added_by')->unique()->filter();
        $users = \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id');

        foreach ($attached as $tag) {
            $tag->added_by_user = $users[$tag->pivot->added_by] ?? null;
            $tag->added_at = $tag->pivot->added_at;
        }

        return view('livewire.task-tags', [
            'attached' => $attached,
            'available' => $this->availableTags,
        ]);
    }
}
