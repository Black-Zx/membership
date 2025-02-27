

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Register New Member</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('members.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Phone</label>
            <input type="number" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Street</label>
            <input type="text" name="street" class="form-control" required>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label>City</label>
                <input type="text" name="city" class="form-control" required>
            </div>
    
            <div class="mb-3 col-md-6">
                <label>State</label>
                <input type="text" name="state" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label>Zip</label>
                <input type="text" name="zip" class="form-control" maxlength="5" required>
            </div>
    
            <div class="form-group mb-3 col-md-6">
                <label class="form-label" for="address_type">Address Type</label>
                <select class="form-select" id="address_type" name="address_type">
                    <option value="" hidden></option>
                    <?php $__currentLoopData = $addressTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(isset($type)): ?>
                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>


        <div class="mb-3 col-md-12">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3 col-md-12">
            <label>Proof of Address (PDF)</label>
            <input type="file" name="proof_of_address" class="form-control" accept=".pdf,image/*">
        </div>

        <div class="mb-3 col-md-12">
            <label>Referred By (Optional) <small style="color:red;">*Referral Code</small></label>
            <input type="text" name="referred_by" class="form-control"  maxlength="8">
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('members.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Asus\Desktop\php\my-first-laravel-project\membership\resources\views/members/create.blade.php ENDPATH**/ ?>