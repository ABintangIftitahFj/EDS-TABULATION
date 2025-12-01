

<?php $__env->startSection('title', 'Adjudicators'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">Adjudicators</h1>
            <p class="text-black">Manage tournament adjudicators and judges</p>
        </div>
        <a href="<?php echo e(route('admin.adjudicators.create')); ?>"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
            + Add Adjudicator
        </a>
    </div>

    <!-- Tournament Filter -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form method="GET" action="<?php echo e(route('admin.adjudicators.index')); ?>" class="flex items-center gap-4">
            <div class="flex-1 max-w-xs">
                <label for="tournament_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Tournament:</label>
                <select id="tournament_id" name="tournament_id" onchange="this.form.submit()"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Tournaments</option>
                    <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tournament->id); ?>" <?php echo e($tournamentFilter == $tournament->id ? 'selected' : ''); ?>>
                            <?php echo e($tournament->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php if($tournamentFilter): ?>
                <a href="<?php echo e(route('admin.adjudicators.index')); ?>" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900">
                    Clear Filter
                </a>
            <?php endif; ?>
        </form>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adjudicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <div class="font-semibold text-black text-lg"><?php echo e($adjudicator->name); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e($adjudicator->institution ?? 'N/A'); ?></div>
                    </div>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                        ⭐ <?php echo e($adjudicator->rating ? number_format($adjudicator->rating, 1) : 'N/A'); ?>

                    </span>
                </div>
                <div class="text-xs text-gray-500 mb-3">
                    🏆 <?php echo e($adjudicator->tournament->name ?? 'N/A'); ?>

                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('admin.adjudicators.edit', $adjudicator)); ?>"
                        class="flex-1 px-3 py-2 bg-indigo-600 text-white text-center text-sm font-medium rounded-lg hover:bg-indigo-700">
                        ✏️ Edit
                    </a>
                    <form action="<?php echo e(route('admin.adjudicators.destroy', $adjudicator)); ?>" method="POST" class="flex-1"
                        onsubmit="return confirm('Are you sure you want to delete this adjudicator?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                <div class="text-4xl mb-2">👨‍⚖️</div>
                <p class="text-gray-500">No adjudicators found.</p>
                <a href="<?php echo e(route('admin.adjudicators.create')); ?>" class="text-indigo-600 hover:text-indigo-500 text-sm">Add one</a>
            </div>
        <?php endif; ?>
        
        <?php if($adjudicators->hasPages()): ?>
            <div class="mt-4"><?php echo e($adjudicators->links()); ?></div>
        <?php endif; ?>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Institution</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Tournament</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Rating</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <?php $__empty_1 = true; $__currentLoopData = $adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adjudicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-black"><?php echo e($adjudicator->name); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black"><?php echo e($adjudicator->institution ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black"><?php echo e($adjudicator->tournament->name ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-black">
                                    <?php echo e($adjudicator->rating ? number_format($adjudicator->rating, 1) : 'N/A'); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?php echo e(route('admin.adjudicators.edit', $adjudicator)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="<?php echo e(route('admin.adjudicators.destroy', $adjudicator)); ?>" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this adjudicator?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-black">
                                No adjudicators found. <a href="<?php echo e(route('admin.adjudicators.create')); ?>" class="text-indigo-600 hover:text-indigo-500">Add one</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($adjudicators->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-200">
                <?php echo e($adjudicators->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\adjudicators\index.blade.php ENDPATH**/ ?>