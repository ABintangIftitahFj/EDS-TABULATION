<!-- Team Creation Modal -->
<div id="team-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-black">Create Team Manually</h3>
                <button onclick="closeModal('team-modal')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="team-form" action="<?php echo e(route('admin.teams.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="tournament_id" value="<?php echo e($tournament->id); ?>">
                
                <div class="space-y-4">
                    <div>
                        <label for="team_name" class="block text-sm font-medium text-gray-700 mb-1">Team Name *</label>
                        <input type="text" id="team_name" name="name" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label for="team_institution" class="block text-sm font-medium text-gray-700 mb-1">Institution *</label>
                        <input type="text" id="team_institution" name="institution" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Speakers</h4>
                        
                        <div class="space-y-3" id="speakers-container">
                            <!-- Speaker fields will be injected here via JS -->
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('team-modal')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Create Team
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateSpeakerFields(format) {
        const container = document.getElementById('speakers-container');
        container.innerHTML = '';
        
        let speakerCount = 3; // Default to Asian (3 speakers)
        if (format === 'british' || format === 'bp') {
            speakerCount = 2;
        }

        for (let i = 1; i <= speakerCount; i++) {
            const div = document.createElement('div');
            div.innerHTML = `
                <label for="speaker_${i}" class="block text-xs font-medium text-gray-500 mb-1">Speaker ${i} *</label>
                <input type="text" id="speaker_${i}" name="speakers[${i-1}][name]" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    placeholder="Speaker Name">
            `;
            container.appendChild(div);
        }
    }
</script>
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Create Team
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let speakerCount = 2;

function addSpeaker() {
    const container = document.getElementById('speakers-container');
    const newSpeaker = document.createElement('div');
    newSpeaker.className = 'speaker-input flex gap-2 mb-2';
    newSpeaker.innerHTML = `
        <input type="text" name="speakers[${speakerCount}][name]" placeholder="Speaker ${speakerCount + 1} Name"
            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        <button type="button" onclick="removeSpeaker(this)" class="px-2 py-1 text-red-600 hover:text-red-500 text-sm">
            Remove
        </button>
    `;
    container.appendChild(newSpeaker);
    speakerCount++;
}

function removeSpeaker(button) {
    button.parentElement.remove();
}
</script><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\tournaments\modals\team-modal.blade.php ENDPATH**/ ?>