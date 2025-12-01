<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-xl shadow-lg overflow-hidden">
    <div class="p-6 text-black">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="text-lg font-bold uppercase tracking-wider">💡 Motion</h3>
                    <?php if($motion->is_released): ?>
                        <span class="ml-auto px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                            ✅ Released
                        </span>
                    <?php endif; ?>
                </div>
                <blockquote class="text-2xl font-serif italic leading-relaxed mb-3">
                    "<?php echo e($motion->title); ?>"
                </blockquote>
                <?php if($motion->detail): ?>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 mt-4">
                        <p class="text-sm leading-relaxed"><?php echo e($motion->detail); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if($motion->info_slide): ?>
            <div class="mt-4 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold mb-1">📝 Info Slide</h4>
                        <p class="text-sm opacity-90"><?php echo e($motion->info_slide); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($motion->category): ?>
            <div class="mt-3 flex items-center gap-2">
                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                    🏷️ <?php echo e($motion->category); ?>

                </span>
                <?php if($motion->released_at): ?>
                    <span class="text-xs opacity-75">
                        Released: <?php echo e($motion->released_at->format('M d, Y H:i')); ?>

                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\components\motion-card.blade.php ENDPATH**/ ?>