

<?php $__env->startSection('title', 'Manage Tournaments'); ?>

<?php $__env->startSection('content'); ?>
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tournaments</h1>
            <p class="mt-2 text-sm text-gray-700">Daftar semua turnamen debat yang terdaftar dalam sistem.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="<?php echo e(route('admin.tournaments.create')); ?>"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                + Add Tournament
            </a>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $statusColors = [
                    'draft' => 'bg-gray-100 text-gray-600',
                    'ongoing' => 'bg-green-100 text-green-700',
                    'completed' => 'bg-blue-100 text-blue-700',
                ];
                $colorClass = $statusColors[$tournament->status] ?? 'bg-gray-100 text-gray-600';
            ?>
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <div class="font-semibold text-black text-lg"><?php echo e($tournament->name); ?></div>
                        <div class="text-xs text-gray-500">📍 <?php echo e($tournament->location ?? 'Online'); ?></div>
                    </div>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($colorClass); ?>">
                        <?php echo e(ucfirst($tournament->status)); ?>

                    </span>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 uppercase">
                        <?php echo e($tournament->format); ?>

                    </span>
                    <span class="text-xs text-gray-500">
                        <?php echo e(\Carbon\Carbon::parse($tournament->start_date)->format('d M')); ?> - <?php echo e(\Carbon\Carbon::parse($tournament->end_date)->format('d M Y')); ?>

                    </span>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <a href="<?php echo e(route('admin.tournaments.show', $tournament->id)); ?>"
                        class="px-3 py-2 bg-indigo-600 text-white text-center text-xs font-medium rounded-lg hover:bg-indigo-700">
                        ⚙️ Manage
                    </a>
                    <a href="<?php echo e(route('admin.tournaments.edit', $tournament->id)); ?>"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-center text-xs font-medium rounded-lg hover:bg-gray-200">
                        ✏️ Edit
                    </a>
                    <form action="<?php echo e(route('admin.tournaments.destroy', $tournament->id)); ?>" method="POST"
                        onsubmit="return confirm('Are you sure? This will delete all matches and rounds associated.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                <div class="text-4xl mb-2">🏆</div>
                <h3 class="text-sm font-medium text-gray-900">No tournaments found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new tournament.</p>
                <div class="mt-4">
                    <a href="<?php echo e(route('admin.tournaments.create')); ?>"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        + Create Tournament
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900"><?php echo e($tournament->name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($tournament->location ?? 'Online'); ?></div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 uppercase">
                                    <?php echo e($tournament->format); ?>

                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($tournament->start_date)->format('d M Y')); ?>

                                <span class="text-gray-400 mx-1">-</span>
                                <?php echo e(\Carbon\Carbon::parse($tournament->end_date)->format('d M Y')); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <?php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-600 ring-gray-500/10',
                                        'ongoing' => 'bg-green-100 text-green-700 ring-green-600/20',
                                        'completed' => 'bg-blue-100 text-blue-700 ring-blue-700/10',
                                    ];
                                    $colorClass = $statusColors[$tournament->status] ?? 'bg-gray-100 text-gray-600';
                                ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset <?php echo e($colorClass); ?>">
                                    <?php echo e(ucfirst($tournament->status)); ?>

                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="<?php echo e(route('admin.tournaments.show', $tournament->id)); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold">Manage</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="<?php echo e(route('admin.tournaments.edit', $tournament->id)); ?>" class="text-gray-600 hover:text-blue-600">Edit</a>
                                    <form action="<?php echo e(route('admin.tournaments.destroy', $tournament->id)); ?>" method="POST"
                                        onsubmit="return confirm('Are you sure? This will delete all matches and rounds associated.');" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No tournaments found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new tournament.</p>
                                <div class="mt-6">
                                    <a href="<?php echo e(route('admin.tournaments.create')); ?>"
                                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                        + Create Tournament
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/admin/tournaments/index.blade.php ENDPATH**/ ?>