<div>
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-zinc-300 rounded-2xl shadow-2xl p-6 w-full max-w-md mx-auto">
            <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Create Task</h2>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" wire:model="title" class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('title')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" wire:model="description"
                           class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('description')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select wire:model.lazy="status" class="mt-1 block w-full border p-2 rounded text-gray-900">
                        <option value="todo">Todo</option>
                        <option value="doing">Doing</option>
                        <option value="done">Done</option>
                        <option value="blocked">Blocked</option>
                    </select>
                    @error('status')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Assign to Project</label>
                    <select wire:model="projectId" class="mt-1 block w-full border p-2 rounded text-gray-900">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('projectId')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="class=block text-sm font-medium text-gray-700">Assign Assignee</label>
                    <select wire:model="assigneeId" class="mt-1 block w-full border p-2 rounded text-gray-900">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('userId')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" wire:model="dueDate"
                           class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('dueDate')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estimated minutes</label>
                    <input type="number" wire:model="estimateMinutes"
                           class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('estimatedMinutes')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Priority</label>
                    <select wire:model.lazy="priority" class="mt-1 block w-full border p-2 rounded text-gray-900">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    @error('priority')
                    <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="$dispatch('closeModal')"
                            class="px-4 py-2 bg-gray-800 rounded text-white">Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
