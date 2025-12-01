

<?php $__env->startSection('title', 'Create Team'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black">Create New Team</h1>
        <p class="text-black">Add a new team to a tournament</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="<?php echo e(route('admin.teams.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="space-y-6">
                <div>
                    <label for="tournament_id" class="block text-sm font-medium text-black">Tournament</label>
                    <select id="tournament_id" name="tournament_id" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Tournament</option>
                        <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tournament->id); ?>" data-format="<?php echo e($tournament->format); ?>" <?php echo e((old('tournament_id') ?? request('tournament_id')) == $tournament->id ? 'selected' : ''); ?>>
                                <?php echo e($tournament->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['tournament_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-black">Team Name</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-black">Institution</label>
                    <input type="text" name="institution" id="institution" value="<?php echo e(old('institution')); ?>" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <?php $__errorArgs = ['institution'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-black mb-2">Speakers</label>
                    <div id="speakers-container" class="space-y-3">
                        <div class="speaker-input flex gap-2">
                            <input type="text" name="speakers[0][name]" placeholder="Speaker 1 Name" required
                                class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="speaker-input flex gap-2">
                            <input type="text" name="speakers[1][name]" placeholder="Speaker 2 Name" required
                                class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <button type="button" id="add-speaker"
                        class="mt-3 inline-flex items-center px-3 py-1.5 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-black bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        + Add Speaker
                    </button>
                    <?php $__errorArgs = ['speakers'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="<?php echo e(route('admin.teams.index')); ?>"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-black shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Create Team
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        const tournamentSelect = document.getElementById('tournament_id');
        const speakersContainer = document.getElementById('speakers-container');
        const addSpeakerBtn = document.getElementById('add-speaker');
        
        // Hide add button as we enforce count based on format
        if(addSpeakerBtn) addSpeakerBtn.style.display = 'none';

        function updateSpeakers(format) {
            // Save current values if any
            const currentInputs = Array.from(speakersContainer.querySelectorAll('input'));
            const currentValues = currentInputs.map(input => input.value);

            speakersContainer.innerHTML = '';
            let count = 2; // Default/British
            if (format === 'asian') {
                count = 3;
            }
            
            for (let i = 0; i < count; i++) {
                const div = document.createElement('div');
                div.className = 'speaker-input flex gap-2';
                const value = currentValues[i] || '';
                div.innerHTML = `
                    <input type="text" name="speakers[${i}][name]" value="${value}" placeholder="Speaker ${i + 1} Name" required
                        class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                `;
                speakersContainer.appendChild(div);
            }
        }

        tournamentSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const format = selectedOption.getAttribute('data-format');
            if (format) {
                updateSpeakers(format);
            }
        });
        
        // Initial check
        if (tournamentSelect.value) {
             const selectedOption = tournamentSelect.options[tournamentSelect.selectedIndex];
             const format = selectedOption.getAttribute('data-format');
             if (format) {
                 updateSpeakers(format);
             }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\teams\create.blade.php ENDPATH**/ ?>