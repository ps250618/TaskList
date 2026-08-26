<div>
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-zinc-300 rounded-2xl shadow-2xl p-6 w-full max-w-md mx-auto">
            <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Create Project</h2>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" wire:model="description"
                           class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('description')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Code</label>
                    <input type="text" wire:model="code" class="mt-1 block w-full border p-2 rounded text-gray-900">
                    @error('code')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select wire:model.lazy="status" class="mt-1 block w-full border p-2 rounded text-gray-900">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="on_hold">On hold</option>
                        <option value="archived">Archived</option>
                    </select>
                    @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Assign to Team</label>
                    <select wire:model="teamId" class="mt-1 block w-full border p-2 rounded text-gray-900">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                    @error('teamId')
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
