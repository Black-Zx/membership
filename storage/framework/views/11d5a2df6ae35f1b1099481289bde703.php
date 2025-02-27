<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('members.layouts.meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('members.layouts.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('members.index')); ?>">Membership App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('members.index')); ?>">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('members.create')); ?>">Register Member</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php echo $__env->make('members.layouts.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
</body>
</html>
<?php /**PATH C:\Users\Asus\Desktop\php\my-first-laravel-project\membership\resources\views/members/layouts/app.blade.php ENDPATH**/ ?>