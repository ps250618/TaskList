<div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-red-600 hover:underline">
            Log Out
        </button>
    </form>
    <nav>
        @role('admin|manager')
        <a href="/teams" wire:navigate class="mr-4 text-blue-600 hover:underline">Teams</a>
        <a href="/projects" wire:navigate class="mr-4 text-blue-600 hover:underline">Projects</a>
        @endrole
        <a href="/tasks" wire:navigate class="mr-4 text-blue-600 hover:underline">Tasks</a>
    </nav>

    <div class="mt-4">
        <input type="text" wire:model.live.debounce.300ms="search"
               placeholder="Search title or description..."
               class="p-2 border rounded w-full sm:w-64 mb-4">

        @role('admin|manager')
        <button wire:click="$dispatch('openModal', { component: 'task-modal' })"
                class="px-4 py-2 bg-zinc-500 text-white rounded hover:bg-gray-400">New Task
        </button>
        @endrole

        <select wire:model="filterStatus" class="p-2 border rounded mb-4 bg-gray-500">
            <option value="">All Statuses</option>
            <option value="todo">Todo</option>
            <option value="doing">Doing</option>
            <option value="done">Done</option>
            <option value="blocked">Blocked</option>
        </select>

        <select wire:model="filterProject" class="p-2 border rounded mb-4 bg-gray-500">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>

        <select wire:model="filterPriority" class="p-2 border rounded mb-4 bg-gray-500">
            <option value="">All Priorities</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>

        <select wire:model="filterDue" class="p-2 border rounded mb-4 bg-gray-500">
            <option value="">All Due Dates</option>
            <option value="overdue">Overdue</option>
            <option value="today">Due Today</option>
            <option value="this_week">Due This Week</option>
        </select>

            <livewire:tasks-table
                :tasks="$tasks->items()"
                :wire:key="'tasks-' . md5($search . $filterStatus . $filterPriority . $filterProject . $filterDue .
            $sortField . $sortDirection . $tasks->currentPage())"
            />

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
