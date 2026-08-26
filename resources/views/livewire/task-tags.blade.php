<div>
    <div class="space-y-4 text-sm text-gray-700">
        <div class="flex gap-2">
            <select wire:model="selectedTagId" class="flex-1 border rounded p-2">
                <option value="">Select tag...</option>
                @foreach($available as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <button wire:click="attachTag" class="px-3 py-2 bg-blue-600 text-white rounded">
                Add
            </button>
        </div>

        <div>
            <h4 class="font-semibold mb-2">Attached Tags</h4>
            <div class="flex flex-wrap gap-2">
                @forelse($attached as $tag)
                    <span class="bg-gray-200 px-2 py-1 rounded inline-flex items-center flex-col">
                        <div class="flex items-center gap-2">
                            <span>{{ $tag->name }}</span>
                            <button wire:click="detachTag({{ $tag->id }})" class="ml-2 text-red-600">×</button>
                        </div>
                        <small
                            class="text-gray-600">added by: {{ optional($tag->added_by_user)->name ?? 'Unknown' }}
                        </small>
                        <small class="text-gray-600">added at: {{ $tag->created_at->format('M d, Y') }}
                        </small>
                    </span>
                @empty
                    <p class="text-gray-500">No tags attached.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
