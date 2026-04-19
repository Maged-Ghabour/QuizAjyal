
<div class="space-y-3">
    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label class="option-card flex items-center gap-4 group hover:bg-white/10 hover:border-primary/40 cursor-pointer has-[:checked]:bg-primary/15 has-[:checked]:border-primary/50" for="option-<?php echo e($option->id); ?>">
            <input type="radio"
                   name="answers[<?php echo e($question->id); ?>]"
                   value="<?php echo e($option->id); ?>"
                   id="option-<?php echo e($option->id); ?>"
                   class="w-5 h-5 text-primary bg-white/5 border-white/20 focus:ring-primary/50 focus:ring-offset-0 cursor-pointer">
            <div class="flex items-center gap-3 flex-1">
                <span class="inline-flex items-center justify-center w-7 h-7 bg-white/10 rounded-lg text-xs font-bold text-gray-300 group-hover:text-white group-hover:bg-primary/20 transition-colors">
                    <?php echo e($option->label); ?>

                </span>
                <span class="text-gray-200 group-hover:text-white transition-colors"><?php echo e($option->option_text); ?></span>
            </div>
        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/components/questions/mcq.blade.php ENDPATH**/ ?>