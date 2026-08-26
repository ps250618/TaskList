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
                <h1 class="text-2xl font-semibold text-gray-900">Teams</h1>
                @role('admin')
                <button wire:click="$dispatch('openModal', { component: 'team-modal' })"
                        class="px-4 py-2 bg-zinc-500 text-white rounded hover:bg-gray-400">New Team
                </button>
                @endrole
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-300 bg-gray-800 rounded-xl shadow-md">
                    <thead class="bg-gray-700 text-gray-100 uppercase text-xs tracking-wider">
                    <tr>
                        @role('admin')
                        <th class="p-3 text-left text-xs font-medium text-gray-100">ID</th>@endrole
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Team</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-100">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teams as $team)
                        <tr wire:key="team-{{ $team->id }}" class="border-t">
                            @role('admin')
                            <td class="p-3 text-sm text-gray-100">{{ $team->id }}</td>
                            @endrole

                            <td class="p-3 text-sm">
                                @role('admin')
                                <input type="text" wire:model.lazy="names.{{ $team->id }}"
                                       wire:change="updateTeam($event.target.value, {{ $team->id }})"
                                       class="w-full border p-2 rounded text-gray-100">
                                @error("names.{$team->id}")
                                <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                                @else
                                    <span class="text-gray-100">{{ $team->name }}</span>
                                    @endrole
                            </td>
                            <td class="p-3 text-sm">
                                <a href="/teams/{{ $team->id }}" wire:navigate class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>









