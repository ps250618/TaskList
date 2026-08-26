<div>
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-zinc-300 rounded-2xl shadow-2xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $project->name }}</h1>
                @if($project->description)
                    <p class="mt-2 text-sm text-gray-700">{{ $project->description }}</p>
                @endif

                <div class="mt-3 flex items-center gap-3 text-xs">
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'on_hold' => 'bg-yellow-100 text-yellow-800',
                            'archived' => 'bg-red-100 text-red-800',
                        ];
                        $badgeClass = $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span
                        class="px-2 py-1 rounded-full font-semibold {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                    @if($project->code)
                        <span
                            class="px-2 py-1 bg-white rounded text-xs text-gray-700 border">{{ $project->code }}</span>
                    @endif
                    <span class="text-gray-600">•</span>
                    <span class="text-gray-600 text-xs">Tasks: {{ $project->tasks->count() }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <a href="/projects" wire:navigate class="px-3 py-2 bg-gray-800 text-white rounded">Back</a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2 bg-white rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-medium text-gray-800">Tasks</h2>
                <ul class="mt-3 space-y-3">
                    @forelse($project->tasks as $task)
                        <li class="flex items-center justify-between gap-3">
                            <div>
                                <div class="text-sm font-medium text-gray-800">{{ $task->title }}</div>
                                <div class="text-xs text-gray-500">{{ $task->description ?? '' }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                @php
                                    $taskStatusColors = ['todo'=>'bg-gray-100 text-gray-800','in_progress'=>'bg-yellow-100 text-yellow-800','done'=>'bg-green-100 text-green-800','blocked'=>'bg-red-100 text-red-800'];
                                    $tBadge = $taskStatusColors[$task->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span
                                    class="px-2 py-1 text-xs rounded-full font-semibold {{ $tBadge }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                <a href="/tasks/{{ $task->id }}" wire:navigate
                                   class="text-sm text-blue-600 hover:underline">View</a>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-600">No tasks yet.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-medium text-gray-800">Project Info</h2>
                <div class="mt-3 space-y-3 text-sm text-gray-700">
                    <div>
                        <div class="text-xs text-gray-500">Assigned Team</div>
                        @if($project->team)
                            <a href="/teams/{{ $project->team->id }}" wire:navigate
                               class="block mt-1 font-medium text-gray-800 hover:underline">{{ $project->team->name }}</a>
                        @else
                            <div class="mt-1 text-gray-600">Unassigned</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Created</div>
                        <div class="mt-1">{{ $project->created_at->diffForHumans() }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Last updated</div>
                        <div class="mt-1">{{ $project->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
