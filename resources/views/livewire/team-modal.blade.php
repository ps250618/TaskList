<div>
<div class="fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-zinc-300 rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Make new Team</h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label for="team-name" class="block text-sm font-medium text-gray-700">Team name</label>
                <input id="team-name" type="text" wire:model="name"
                       class="mt-1 block w-full border border-gray-300 rounded-lg p-2 text-gray-900">
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" wire:click="$dispatch('closeModal')"
                        class="px-4 py-2 bg-gray-800 rounded hover:bg-gray-400 text-white">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-400 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
