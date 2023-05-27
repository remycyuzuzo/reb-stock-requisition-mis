<?php

$page_title = "Update a user role \"$role_info[role_name]\"";

include VIEWS_FOLDER . "/layouts/head.php";

include VIEWS_FOLDER . "/layouts/top-nav.php";

include VIEWS_FOLDER . "/layouts/sidebar.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update a user role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= url_path('/users/roles') ?>">User roles</a></li>
                        <li class="breadcrumb-item active">Update a role</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="user-role-form">
                <?php if (has('error') || has('success')) flash_show() ?>
                <div class="my-2 row justify-content-center">
                    <div class="col-sm-10 col-md-6 col-xl-5">
                        <h3>Update a user group</h3>
                        <p class="text-muted">Fields marked as <span class="text-danger">*</span> are required</p>
                        <form action="<?= url_path('/users/roles/update/' . $role_info['id']) ?>" method="POST">
                            <div class="form-group">
                                <label for="role_name">Role title</label>
                                <input type="text" id="role_name" value="<?= $role_info['role_name'] ?>" name="role_name" class="form-control" placeholder="Role title eg. System Administrator">
                            </div>
                            <div class="form-group">
                                <label for="role_name">Permissions <span class="text-danger">*</span></label>
                                <small class="text-muted">select all that apply</small>
                                <?php if (isset($all_permissions)) : ?>
                                    <fieldset>
                                        <?php
                                        $role_perms = getRolePermissions($role_info['id']);
                                        foreach ($all_permissions as $value) : ?>
                                            <label for="perm_<?= $value['id'] ?>" class="bg-light border py-1 px-3 mx-1 rounded-lg single_permission_pod">
                                                <input type="checkbox" id="perm_<?= $value['id'] ?>" value="<?= $value['id'] ?>" name="permissions[]" <?= in_array($value['perm_name'], $role_perms) ? 'checked' : '' ?>>
                                                <?= $value['perm_name'] ?>
                                            </label>
                                        <?php endforeach ?>
                                    </fieldset>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-light border" onclick="history.back()"><i class="fas fa-arrow-alt-circle-left"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Update</button>
                            </div>
                            <input type="hidden" name="role_id" value="<?= $role_info['id'] ?>">
                        </form>
                    </div>
                </div><!-- ./collapse -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include VIEWS_FOLDER . "/layouts/aside-menu.php";

include VIEWS_FOLDER . "/layouts/footer.php";

include VIEWS_FOLDER . "/layouts/foot.php"
?>
<script src="<?= STATIC_FOLDER_URL . '/assets/libs/jquery-validation/jquery.validate.min.js' ?>"></script>
<script>
    $('#newUserForm').validate({
        rules: {
            email: {
                email: true,
                required: true,
            }

        }
    });