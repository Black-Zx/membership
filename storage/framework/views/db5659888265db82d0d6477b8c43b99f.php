

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Edit Member</h2>
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('members.update', $member->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($member->name); ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo e($member->email); ?>" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo e($member->phone); ?>" required>
        </div>

        <h5>Addresses</h5>
        <?php $__currentLoopData = $member->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="address-group mt-3">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="address_type_id">Address Type:</label>
                        <select class="form-select" name="address_type_id" required>
                            <?php $__currentLoopData = $addressTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>" <?php echo e($type->id == $address->address_type_id ? 'selected' : ''); ?>>
                                    <?php echo e($type->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="street">Street:</label>
                    <input class="form-control w-100" type="text" name="street" value="<?php echo e($address->street); ?>" required>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="city">City:</label>
                        <input class="form-control" type="text" name="city" value="<?php echo e($address->city); ?>" required>
                    </div>
        
                    <div class="mb-3 col-md-4">
                        <label for="state">State:</label>
                        <input class="form-control" type="text" name="state" value="<?php echo e($address->state); ?>" required>
                    </div>
    
                    <div class="mb-3 col-md-4">
                        <label for="zip">Zip Code:</label>
                        <input class="form-control" type="text" name="zip" value="<?php echo e($address->zip); ?>" maxlength="5" required>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <?php $__currentLoopData = \App\Models\Member::getStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php echo e($member->status == $status ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($status)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        

        <div class="my-3">
            <label>Profile Image</label>
            <?php if($profileImage->documents()->exists()): ?>
                <?php if($profileImage = $profileImage->documents->first()): ?>
                    <div>
                        <img src="<?php echo e(asset('documents/' . $profileImage->file_path)); ?>" width="100">
                        <p>Current Profile Image</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <?php if(isset($proofOfAddress)): ?>
                <?php if($proofOfAddress->documents()->exists()): ?>    
                    <label>Documents</label>
                    <?php $__currentLoopData = $proofOfAddress->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><a href="<?php echo e(asset('documents/' . $document->file_path)); ?>" target="_blank">View Proof of Address</a></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <p>Current Proof of Address</p>
            <?php endif; ?>
            <input type="file" name="proof_of_address" class="form-control" accept=".pdf,image/*">
        </div>

        <button type="submit" class="btn btn-warning mb-2">Update</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('members.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Asus\Desktop\php\my-first-laravel-project\membership\resources\views/members/edit.blade.php ENDPATH**/ ?>