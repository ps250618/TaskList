<div class="max-w-4xl mx-auto p-6">
    <nav class="mb-6 border-b pb-2 flex flex-wrap items-center gap-4 text-sm text-gray-700">
        @role('admin|manager')
        <a href="/teams" wire:navigate class="hover:text-blue-600">Teams</a>
        <a href="/projects" wire:navigate class="hover:text-blue-600">Projects</a>
        @endrole
        <a href="/tasks" wire:navigate class="hover:text-blue-600 font-semibold">Tasks</a>
    </nav>

    <div x-data="{ activeTab: 'details' }" class="bg-gray-600 rounded-2xl shadow-xl p-6 border border-gray-200">
        <nav class="flex gap-6 border-b mb-6">
            @foreach(['details' => 'Details', 'tags' => 'Tags', 'comments' => 'Comments'] as $tab => $label)
                <button
                    :class="activeTab === '{{ $tab }}'
                        ? 'text-blue-600 border-blue-600 font-semibold border-b-2'
                        : 'text-gray-500 hover:text-gray-700'"
                    @click="activeTab = '{{ $tab }}'"
                    class="pb-2 transition-colors duration-200">
                    {{ $label }}
                </button>
            @endforeach
        </nav>

        <div x-show="activeTab === 'details'" x-cloak class="space-y-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Task Information</h2>
                <div class="bg-gray-50 rounded-lg p-4 grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
                    <p><strong>Title:</strong> {{ $task->title }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
                    <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
                    <p><strong>Due Date:</strong> {{ $task->due_date?->format('Y-m-d') ?? 'N/A' }}</p>
                    <div class="sm:col-span-2">
                        <strong>Description:</strong>
                        <p class="mt-1 text-gray-600">{{ $task->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Update Status</h3>
                    <select wire:model="statuses.{{ $task->id }}"
                            wire:change="updateStatus({{ $task->id }})"
                            class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @foreach(['todo'=>'To Do','doing'=>'Doing','done'=>'Done','blocked'=>'Blocked'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error("statuses.{$task->id}")
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Update Priority</h3>
                    <select wire:model="priorities.{{ $task->id }}"
                            wire:change="updatePriority({{ $task->id }})"
                            class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error("priorities.{$task->id}")
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Update Due Date</h3>
                    <input type="date"
                           wire:model.lazy="due_dates.{{ $task->id }}"
                           wire:change="updateDate({{ $task->id }})"
                           class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error("due_dates.{$task->id}")
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @role('admin|manager')
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Update Assignee</h3>
                    <select wire:model="assignee_ids.{{ $task->id }}"
                            wire:change="updateAssignee({{ $task->id }})"
                            class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @foreach($assignees as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error("assignee_ids.{$task->id}")
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endrole
            </div>
        </div>


        <div x-show="activeTab === 'tags'" x-cloak class="space-y-3 text-gray-700">
            <h2 class="text-lg font-semibold text-gray-800">Tags</h2>
            <livewire:task-tags :task="$task"/>
        </div>

        <div x-show="activeTab === 'comments'" x-cloak class="space-y-3 text-gray-700">
            <h2 class="text-lg font-semibold text-gray-800">Comments</h2>
            <livewire:comments :task="$task" />
        </div>
    </div>
</div>
