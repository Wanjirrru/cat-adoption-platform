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
    <div class="container mx-auto px-5 py-12">
        <h1 class="text-3xl font-bold text-rose-600 mb-8">Available Cuties</h1>

        <!-- Add New Cat Button for Super Admin/Admin -->
        <?php if(Auth::check() && Auth::user()->hasRole('super-admin|admin')): ?>
            <a href="<?php echo e(route('cats.create')); ?>" class="mb-6 inline-block px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 transition-transform transform hover:scale-105">
                Add New Cat
            </a>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php
                        $images = is_string($cat->images) ? json_decode($cat->images, true) : $cat->images;
                    ?>

                    <!-- Cat Image -->
                    <img
                        src="<?php echo e(isset($images[0]) ? asset('storage/' . $images[0]) : asset('storage/default-image.jpg')); ?>"
                        alt="<?php echo e($cat->name); ?>"
                        class="w-full h-48 object-cover"
                    >

                    <!-- Cat Details -->
                    <div class="p-4">
                        <h5 class="text-xl font-bold text-gray-800"><?php echo e($cat->name); ?></h5>
                        <p class="text-gray-600">Breed: <?php echo e($cat->breed); ?></p>
                        <p class="text-gray-600">Price: $<?php echo e($cat->price); ?></p>
                        <p class="text-gray-700 mt-2"><?php echo e($cat->description); ?></p>

                        <div class="mt-4 space-y-2">
                            <!-- View Details Button -->
                            <a href="<?php echo e(route('cats.show', $cat->id)); ?>" class="block px-4 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-transform transform hover:scale-105">
                                View Details
                            </a>

                            <!-- Delete Button for Super Admin/Admin -->
                            <?php if(Auth::check() && Auth::user()->hasRole('super-admin|admin')): ?>
                                <form action="<?php echo e(route('cats.destroy', $cat->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this cat?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-transform transform hover:scale-105">
                                        Delete Cat
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Adopt Button for Users -->
                            <?php if(Auth::check() && Auth::user()->hasRole('user')): ?>
                                <a href="<?php echo e(route('adoptions.create', $cat->id)); ?>" class="block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-transform transform hover:scale-105">
                                    Adopt
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php echo e($cats->links()); ?>

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
<?php endif; ?><?php /**PATH /home/melissa/DevOps/cat-adoption-platform/backend/resources/views/cats/index.blade.php ENDPATH**/ ?>