

<?php $__env->startSection('title', 'Create Tournament'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-2xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-black sm:truncate sm:text-3xl sm:tracking-tight">
                    Create New Tournament
                </h2>
            </div>
        </div>

        <form action="<?php echo e(route('admin.tournaments.store')); ?>" method="POST"
            class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-8">
            <?php echo csrf_field(); ?>

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-black">Tournament Name</label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name"
                            class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="e.g. EDS Open 2024" required>
                    </div>
                </div>

                <div>
                    <label for="format" class="block text-sm font-medium leading-6 text-black">Format</label>
                    <div class="mt-2">
                        <select id="format" name="format"
                            class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="asian">Asian Parliamentary (3-on-3)</option>
                            <option value="british">British Parliamentary (2-on-2)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="start_date" class="block text-sm font-medium leading-6 text-black">Start
                            Date</label>
                        <div class="mt-2">
                            <input type="date" name="start_date" id="start_date"
                                class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="end_date" class="block text-sm font-medium leading-6 text-black">End Date</label>
                        <div class="mt-2">
                            <input type="date" name="end_date" id="end_date"
                                class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium leading-6 text-black">Location</label>
                    <div class="mt-2">
                        <input type="text" name="location" id="location"
                            class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium leading-6 text-black">Description</label>
                    <div class="mt-2">
                        <textarea id="description" name="description" rows="3"
                            class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-black focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-x-6">
                <a href="<?php echo e(route('admin.tournaments.index')); ?>"
                    class="text-sm font-semibold leading-6 text-black">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save
                    Tournament</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/admin/tournaments/create.blade.php ENDPATH**/ ?>