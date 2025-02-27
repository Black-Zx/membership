

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Member List</h2>
    
    <div class="d-flex flex-wrap align-items-center gap-3 my-3">
        <form method="GET" action="<?php echo e(route('members.index')); ?>" class="d-flex gap-2">
            <input type="text" name="search" placeholder="Search by name, email, referral code" value="<?php echo e(request('search')); ?>" class="form-control">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <form action="<?php echo e(route('export')); ?>" method="GET">
            <input type="text" name="search" placeholder="Search members..." value="<?php echo e(request('search')); ?>" hidden>
            <button type="submit" class="btn btn-success">Export CSV</button>
        </form>
        
        <form method="GET" action="<?php echo e(route('members.index')); ?>" class="w-25">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="all">All Statuses</option>
                <?php $__currentLoopData = \App\Models\Member::getStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($status)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
    </div>


    <table class="table table-hover">
        <thead class="border-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Referral Code</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($member->name); ?></td>
                <td><?php echo e($member->email); ?></td>
                <td><?php echo e($member->referral_code); ?></td>
                <td>
                    <span class="badge bg-<?php echo e($member->status == 'approved' ? 'success' : ($member->status == 'pending' ? 'warning' : 'danger')); ?>">
                        <?php echo e(ucfirst($member->status)); ?>

                    </span>
                </td>
                <td class="d-flex flex-wrap align-items-center gap-2">
                    <a href="<?php echo e(route('members.show', $member->id)); ?>" class="btn btn-primary btn-sm">View</a>
                    <a href="<?php echo e(route('members.edit', $member->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('members.destroy', $member->id)); ?>" onsubmit="return confirm('Are you sure?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($members->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('members.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Asus\Desktop\php\my-first-laravel-project\membership\resources\views/members/list.blade.php ENDPATH**/ ?>