<!-- Adjudicator Creation Modal -->
<div id="adjudicator-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-black">Create Adjudicator Manually</h3>
                <button onclick="closeModal('adjudicator-modal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="adjudicator-form" action="{{ route('admin.adjudicators.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label for="adj_name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" id="adj_name" name="name" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label for="adj_institution" class="block text-sm font-medium text-gray-700 mb-1">Institution *</label>
                        <input type="text" id="adj_institution" name="institution" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label for="adj_rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <input type="number" id="adj_rating" name="rating" step="0.1" min="0" max="10" value="0"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Rating from 0 to 10 (optional)</p>
                    </div>

                    <div>
                        <label for="adj_level" class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                        <select id="adj_level" name="level"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="trainee">Trainee</option>
                            <option value="panelist" selected>Panelist</option>
                            <option value="chair">Chair</option>
                            <option value="deputy_chair">Deputy Chair</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('adjudicator-modal')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700">
                        Create Adjudicator
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>