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

    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-zinc-300 rounded-2xl shadow-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-semibold text-gray-900">Projects</h1>
                @role('admin')
                <button wire:click="$dispatch('openModal', { component: 'project-modal' })"
                        class="px-4 py-2 bg-zinc-500 text-white rounded hover:bg-gray-400">New Project
                </button>
                @endrole
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-300 bg-gray-800 rounded-xl shadow-md">
                    <thead class="bg-gray-700 text-gray-100 uppercase text-xs tracking-wider">
                    <tr>
                        @role('admin')
                        <th class="p-3 text-left text-xs font-medium text-gray-100">ID</th>
                        @endrole
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Name</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Description</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Code</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Team</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Status</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Action</th>
                        @role('admin')
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Forbidden action</th>
                        @endrole
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr wire:key="project-{{ $project->id }}" class="border-t">
                            @role('admin')
                            <td class="p-3 text-sm text-gray-100">
                                {{ $project->id }}
                            </td>
                            @endrole
                            <td class="p-3 text-sm text-gray-100">
                                @role('admin')
                                <input type="text"
                                       wire:model.lazy="names.{{ $project->id }}"
                                       wire:change="updateNames({{ $project->id }})"
                                       class="w-full border p-2 rounded text-gray-100">
                                @error("names.{$project->id}")
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                @else
                                    {{ $project->name }}
                                    @endrole
                            </td>

                            <td class="p-3 text-sm text-gray-100">
                                @role('admin')
                                <input type="text"
                                       wire:model.lazy="descriptions.{{ $project->id }}"
                                       wire:change="updateDescriptions({{ $project->id }})"
                                       class="w-full border p-2 rounded text-gray-100">
                                @error("descriptions.{$project->id}")
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                @else
                                    {{ $project->description }}
                                    @endrole
                            </td>

                            <td class="p-3 text-sm text-gray-100">
                                @role('admin')
                                <input type="text"
                                       wire:model.lazy="codes.{{ $project->id }}"
                                       wire:change="updateCodes({{ $project->id }})"
                                       class="w-full border p-2 rounded text-gray-100">
                                @error("codes.{$project->id}")
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                @else
                                    {{ $project->code }}
                                    @endrole
                            </td>

                            <td class="p-3 text-sm text-gray-100">
                                @role('admin')
                                <select wire:model="teamIds.{{ $project->id }}"
                                        wire:change="updateTeamIds({{ $project->id }})"
                                        class="w-full border p-2 rounded text-gray-100">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                @error("teamIds.{$project->id}")
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                @else
                                    {{ $project->team->name ?? '-' }}
                                    @endrole
                            </td>

                            <td class="p-3 text-sm text-gray-100">
                                @role('admin')
                                <select wire:model="statuses.{{ $project->id }}"
                                        wire:change="updateStatuses({{ $project->id }})"
                                        class="w-full border p-2 rounded text-gray-100">
                                    @foreach(['active'=>'Active','inactive'=>'Inactive','on_hold'=>'On Hold','archived'=>'Archived'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error("statuses.{$project->id}")
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                    @endrole
                            </td>
                            <td class="p-3 text-sm">
                                <a href="/projects/{{ $project->id }}" wire:navigate
                                   class="text-blue-600 hover:underline">View</a>
                            </td>
                            <td class="p-3 text-sm">
                                @role('admin')
                                <div>
                                    <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="softDeleteProject({{ $project->id }})"
                                            class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </div>
                                @endrole
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
