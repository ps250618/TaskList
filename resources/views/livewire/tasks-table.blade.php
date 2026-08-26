<div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-300 bg-gray-800 rounded-xl shadow-md">
            <thead class="bg-gray-700 text-gray-100 uppercase text-xs tracking-wider">
            <tr>
                @role('admin')
                <th class="px-4 py-3">ID</th>
                @endrole

                <th wire:click="sortBy('title')"
                    class="px-4 py-3">Title
                    @if($sortField === 'title')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼'}}</span>
                    @endif
                </th>
                <th wire:click="sortBy('description')"
                    class="px-4 py-3">Description
                    @if($sortField === 'description')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼'}}</span>
                    @endif
                </th>
                <th wire:click="sortBy('status')"
                    class="px-4 py-3">Status
                    @if($sortField === 'status')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼'}}</span>
                    @endif
                </th>
                <th class="px-4 py-3">Project</th>

                <th class="px-4 py-3">Assignee</th>

                <th wire:click="sortBy('due_date')"
                    class="px-4 py-3">Due Date
                    @if($sortField === 'due_date')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼'}}</span>
                    @endif
                </th>
                <th wire:click="sortBy('estimate_minutes')"
                    class="px-4 py-3">Est. Minutes
                    @if($sortField === 'estimate_minutes')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼'}}</span>
                    @endif
                </th>
                <th wire:click="sortBy('priority')"
                    class="px-4 py-3">Priority
                    @if($sortField === 'priority')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼'}}</span>
                    @endif
                </th>
                <th class="px-4 py-3">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
            @forelse($tasks as $task)
                <tr wire:key="task-{{ $task->id }}" class="hover:bg-gray-700 transition">
                    @role('admin')
                    <td class="px-4 py-2 text-gray-400">{{ $task->id }}</td>
                    @endrole
                    <td class="px-4 py-2">
                        @role('admin|manager')
                        <input
                            type="text"
                            wire:model.lazy="titles.{{ $task->id }}"
                            wire:change="updateTitle({{ $task->id }}, $event.target.value)"
                            class="w-full bg-transparent border border-gray-600 rounded-md px-2 py-1 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        @else
                            <span class="text-gray-100">{{ $task->title }}</span>
                            @endrole
                    </td>

                    <td class="px-4 py-2 text-gray-400 truncate max-w-xs">
                        @role('admin|manager')
                        <input
                            type="text"
                            wire:model.lazy="descriptions.{{ $task->id }}"
                            wire:change="updateDescription({{ $task->id }}, $event.target.value)"
                            class="w-full bg-transparent border border-gray-600 rounded-md px-2 py-1 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        @else
                            <span>{{ $task->description }}</span>
                            @endrole
                    </td>

                    <td class="px-4 py-2">
                            <span
                                class="@class([
                                    'px-2 py-1 rounded-full text-xs font-semibold',
                                    'bg-blue-600/20 text-blue-400' => $task->status === 'doing',
                                    'bg-yellow-600/20 text-yellow-400' => $task->status === 'todo',
                                    'bg-green-600/20 text-green-400' => $task->status === 'done',
                                    'bg-red-600/20 text-red-400' => $task->status === 'blocked',
                                ])"
                            >
                                {{ ucfirst($task->status) }}
                            </span>
                    </td>

                    <td class="px-4 py-2 text-gray-300">{{ $task->project->name ?? '—' }}</td>
                    <td class="px-4 py-2 text-gray-300">{{ $task->assignee->name ?? '—' }}</td>

                    <td class="px-4 py-2 text-gray-400">{{ $task->due_date?->format('Y-m-d') ?? 'N/A' }}</td>
                    <td class="px-4 py-2 text-gray-400 text-center">{{ $task->estimate_minutes ?? '—' }}</td>

                    <td class="px-4 py-2">
                            <span
                                class="@class([
                                    'px-2 py-1 rounded-full text-xs font-semibold',
                                    'bg-green-700/30 text-green-300' => $task->priority === 'low',
                                    'bg-yellow-700/30 text-yellow-300' => $task->priority === 'medium',
                                    'bg-red-700/30 text-red-300' => $task->priority === 'high',
                                ])"
                            >
                                {{ ucfirst($task->priority) }}
                            </span>
                    </td>

                    <td class="px-4 py-2">
                        <a href="/tasks/{{ $task->id }}" wire:navigate class="text-blue-500 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-500">No tasks found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
