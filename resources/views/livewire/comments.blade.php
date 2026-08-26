<div>
    <div class="space-y-4">
        <div>
            <textarea wire:model="newComment"
                      class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                      rows="3"
                      placeholder="Add a comment..."></textarea>
            @error('comments')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <button wire:click="addComment"
                    class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Submit
            </button>
        </div>

        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="border border-gray-300 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                        <span class="font-semibold text-gray-800">{{ $comment->body }}</span>
                        <span class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-gray-500">No comments yet.</p>
            @endforelse
        </div>
    </div>
</div>
