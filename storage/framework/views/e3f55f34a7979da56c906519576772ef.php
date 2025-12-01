

<?php $__env->startSection('content'); ?>

            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold tracking-tight text-black sm:text-4xl">News & Updates</h1>
                <p class="mt-4 text-lg text-black">Latest stories, achievements, and announcements from EDS UPI.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article
                        class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover"
                                src="<?php echo e($article->image_path ?? 'https://placehold.co/600x400?text=EDS+UPI'); ?>"
                                alt="<?php echo e($article->title); ?>">
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-indigo-600">
                                    <?php echo e($article->category); ?>

                                </p>
                                <a href="/articles/<?php echo e($article->slug); ?>" class="mt-2 block">
                                    <p class="text-xl font-semibold text-black"><?php echo e($article->title); ?></p>
                                    <p class="mt-3 text-base text-black line-clamp-3">
                                        <?php echo e(Str::limit(strip_tags($article->content), 150)); ?></p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="text-sm text-black">
                                    <time
                                        datetime="<?php echo e($article->published_at); ?>"><?php echo e($article->published_at ? $article->published_at->format('M d, Y') : 'Draft'); ?></time>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-full text-center py-12">
                                <p class="text-black">No articles found.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\articles\index.blade.php ENDPATH**/ ?>