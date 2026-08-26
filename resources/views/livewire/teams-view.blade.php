<div>
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-zinc-300 dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $team->name }}</h1>
                @if($team->description ?? false)
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $team->description }}</p>
                @endif
                <div class="mt-3 text-xs text-gray-600 dark:text-gray-400">
                    <span>Members: {{ $team->users->count() }}</span>
                    <span class="mx-2">•</span>
                    <span>Projects: {{ $team->projects->count() }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <a href="/teams" wire:navigate
                   class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 text-sm">Back</a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white dark:bg-gray-900 rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">Members</h2>
                <ul class="mt-3 space-y-2">
                    @forelse($team->users as $user)
                        <li class="flex items-center gap-3">
                            <div
                                class="h-9 w-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div
                                    class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email ?? '' }}</div>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-600 dark:text-gray-400">No members yet.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">Projects</h2>
                <ul class="mt-3 space-y-3">
                    @forelse($team->projects as $project)
                        <li class="flex items-center justify-between gap-3">
                            <div>
                                <div
                                    class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $project->name }}</div>
                                <div
                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $project->description ?? '' }}</div>
                            </div>
                            <div class="flex items-center gap-2">
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
                                    class="px-2 py-1 text-xs rounded-full font-semibold {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                <a href="/projects/{{ $project->id }}" wire:navigate
                                   class="text-sm text-blue-600 hover:underline dark:text-blue-400">View</a>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-600 dark:text-gray-400">No projects yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
