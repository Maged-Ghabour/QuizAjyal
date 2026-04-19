
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label class="option-card relative overflow-hidden group cursor-pointer has-[:checked]:border-primary/60 has-[:checked]:ring-2 has-[:checked]:ring-primary/30 hover:border-primary/40 p-2" for="img-opt-<?php echo e($option->id); ?>">
            <input type="radio"
                   name="answers[<?php echo e($question->id); ?>]"
                   value="<?php echo e($option->id); ?>"
                   id="img-opt-<?php echo e($option->id); ?>"
                   class="sr-only">
            <?php if($option->option_image): ?>
                <img src="<?php echo e('/files/' . $option->option_image); ?>" alt="<?php echo e($option->option_text); ?>" class="w-full h-32 object-cover rounded-lg mb-2">
            <?php endif; ?>
            <div class="text-center">
                <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors"><?php echo e($option->option_text); ?></span>
            </div>
            <div class="absolute top-3 right-3 w-6 h-6 rounded-full border-2 border-white/20 flex items-center justify-center opacity-0 group-has-[:checked]:opacity-100 bg-primary transition-all">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/components/questions/image-choice.blade.php ENDPATH**/ ?>