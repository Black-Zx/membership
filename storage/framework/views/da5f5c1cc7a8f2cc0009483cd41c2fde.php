

<?php $__env->startSection('content'); ?>
<div class="bg-dark me-md-3 p-3 p-md-5 text-white overflow-hidden">
    <div class="my-3 py-3 text-center">
        <h2>Member Details</h2>
    </div>

    <div class="bg-light shadow-sm mx-auto p-3 text-black" style="width: 80%; border-radius: 21px; ">
        <div class="row">
            <div class="col-md-9">
                <p><strong>Name:</strong> <?php echo e($member->name); ?></p>
                <p><strong>Email:</strong> <?php echo e($member->email); ?></p>
                <p><strong>Phone:</strong> <?php echo e($member->phone); ?></p>
                <p><strong>Referral Code:</strong> <?php echo e($member->referral_code); ?></p>
                <p><strong>Status:</strong> <?php echo e($member->status); ?></p>
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><strong>Address:</strong> <?php echo e($address->street); ?>, <?php echo e($address->city); ?>, <?php echo e($address->state); ?>, <?php echo e($address->zip); ?> </p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <p><strong>Referral By:</strong>
                    <a href="" data-bs-toggle="modal" data-bs-target="#refferalByModal">
                        <?php if(isset($member->referrer)): ?>
                            <?php echo e($member->referrer->name); ?>

                        <?php endif; ?>
                    </a> 
                </p>

                <?php if(isset($member->referrer)): ?>
                    <!-- Modal -->
                    <div class="modal fade" id="refferalByModal" tabindex="-1" aria-labelledby="refferalByModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="refferalByModalLabel">Referring Member`s
                                        Information</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Name:</strong> <?php echo e($member->referrer->name); ?></p>
                                    <p><strong>Email:</strong> <?php echo e($member->referrer->email); ?></p>
                                    <p><strong>Referral Code:</strong> <?php echo e($member->referrer->referral_code); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
    
            <div class="col-md-3">
                <?php if(isset($profile_image)): ?>
                    <?php $__currentLoopData = $profile_image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('documents/' . $image->file_path)); ?>" alt="profile image" width="100%">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5">
            <?php if(isset($documents)): ?>
                <?php if($documents->documents()->exists()): ?>    
                    <h4>Documents</h4>
                    <?php $__currentLoopData = $documents->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><a href="<?php echo e(asset('documents/' . $document->file_path)); ?>" target="_blank">View Document</a></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endif; ?>
            
            <a href="<?php echo e(route('members.index')); ?>" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('members.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Asus\Desktop\php\my-first-laravel-project\membership\resources\views/members/detail.blade.php ENDPATH**/ ?>