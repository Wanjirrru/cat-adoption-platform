<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-5">
            <!-- Welcome Section -->
            <div class="text-center mb-32 mt-20">
                <h1 class="text-4xl font-extrabold text-rose-600"> Kiwi Adoption Agency</h1>
                <p class="text-lg text-gray-600 mt-2">Find your perfect feline companion today!</p>
            </div>

            <?php
                $totalCats = \App\Models\Cat::count();
                $adoptedCats = \App\Models\Adoption::where('status', 'completed')->count(); // Cats that have been adopted
                $happyAdopters = \App\Models\User::has('adoptions')->count(); // Users who have adopted cats
            ?>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Total Cats</h3>
                    <p class="text-5xl font-extrabold text-rose-600 mt-2"><?php echo e($totalCats); ?></p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Adopted Cats</h3>
                    <p class="text-5xl font-extrabold text-green-500 mt-2"><?php echo e($adoptedCats); ?></p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Happy Adopters</h3>
                    <p class="text-5xl font-extrabold text-yellow-500 mt-2"><?php echo e($happyAdopters); ?></p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-10">
                <h2 class="text-2xl font-bold text-gray-800">Ready to Adopt?</h2>
                <p class="text-lg text-gray-600 mt-2">Browse all our available cats and find your perfect match!</p>
                <a href="<?php echo e(route('cats.index')); ?>" class="inline-block mt-5 px-8 py-3 text-white bg-rose-600 hover:bg-rose-700 rounded-full font-medium text-lg shadow-lg transform transition-all hover:scale-105 no-underline !no-underline">
                    Explore Cats
                </a>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /home/melissa/DevOps/cat-adoption-platform/backend/resources/views/dashboard.blade.php ENDPATH**/ ?>