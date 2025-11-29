<!-- Room Creation Modal -->
<div id="room-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-black">Create Room Manually</h3>
                <button onclick="closeModal('room-modal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="room-form" action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label for="room_name" class="block text-sm font-medium text-gray-700 mb-1">Room Name *</label>
                        <input type="text" id="room_name" name="name" required placeholder="e.g. Room A101, Auditorium 1"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label for="room_capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity (optional)</label>
                        <input type="number" id="room_capacity" name="capacity" min="1" placeholder="e.g. 50"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Maximum number of people the room can accommodate</p>
                    </div>

                    <div>
                        <label for="room_location" class="block text-sm font-medium text-gray-700 mb-1">Location (optional)</label>
                        <input type="text" id="room_location" name="location" placeholder="e.g. Building A, Floor 2"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label for="room_notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                        <textarea id="room_notes" name="notes" rows="2" placeholder="Any special notes about this room"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('room-modal')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                        Create Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>