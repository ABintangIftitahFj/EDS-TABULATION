

<?php $__env->startSection('title', 'Edit Team'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black">Edit Team</h1>
        <p class="text-black">Update team information and speakers</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="<?php echo e(route('admin.teams.update', $team)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-6">
                <div>
                    <label for="tournament_id" class="block text-sm font-medium text-black">Tournament</label>
                    <select id="tournament_id" name="tournament_id" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Tournament</option>
                        <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tournament->id); ?>"
                                <?php echo e($team->tournament_id == $tournament->id ? 'selected' : ''); ?>>
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
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $team->name)); ?>" required
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
                    <input type="text" name="institution" id="institution"
                        value="<?php echo e(old('institution', $team->institution)); ?>" required
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
                        <?php $__currentLoopData = $team->speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="speaker-input flex gap-2">
                                <input type="hidden" name="speakers[<?php echo e($index); ?>][id]" value="<?php echo e($speaker->id); ?>">
                                <input type="text" name="speakers[<?php echo e($index); ?>][name]"
                                    value="<?php echo e($speaker->name); ?>" placeholder="Speaker <?php echo e($index + 1); ?> Name" required
                                    class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <?php if($index >= 2): ?>
                                    <button type="button"
                                        class="remove-speaker px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Remove</button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <button type="button" id="add-speaker"
                        class="mt-3 inline-flex items-center px-3 py-1.5 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-black bg-white hover:bg-slate-50">
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
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
                    Update Team
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        let speakerCount = <?php echo e(count($team->speakers)); ?>;
        document.getElementById('add-speaker').addEventListener('click', function() {
            const container = document.getElementById('speakers-container');
            const newSpeaker = document.createElement('div');
            newSpeaker.className = 'speaker-input flex gap-2';
            newSpeaker.innerHTML = `
                <input type="text" name="speakers[${speakerCount}][name]" placeholder="Speaker ${speakerCount + 1} Name" required
                    class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <button type="button" class="remove-speaker px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Remove</button>
            `;
            container.appendChild(newSpeaker);
            speakerCount++;
        });

        document.getElementById('speakers-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-speaker')) {
                e.target.closest('.speaker-input').remove();
            }
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\teams\edit.blade.php ENDPATH**/ ?>