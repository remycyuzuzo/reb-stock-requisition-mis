<?php

$page_title = "";

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
                    <h1 class="m-0">User Roles / Permission management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= url_path('/users') ?>">Users</a></li>
                        <li class="breadcrumb-item active">User roles</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
            if (has('success')) {
                flash_show();
            }
            ?>
            <a href="#" title="Create a new user group/role" class="btn btn-warning" data-toggle="collapse" data-target="#newRoleCollapse"><i class="fas fa-plus-circle"></i> create new role</a>
            <hr />
            <div class="collapse user-role-form <?= has('error') ? 'show' : '' ?>" id="newRoleCollapse">
                <?php if (has('error') || has('success')) flash_show() ?>
                <div class="my-2 row justify-content-center">
                    <div class="col-sm-10 col-md-6 col-xl-5">
                        <h3>Create a new user group</h3>
                        <p class="text-muted">Fields marked as <span class="text-danger">*</span> are required</p>
                        <form action="<?= url_path('/users/roles/create-new-role') ?>" method="POST">
                            <div class="form-group">
                                <label for="role_name">Role title</label>
                                <input type="text" id="role_name" name="role_name" class="form-control" placeholder="Role title eg. System Administrator" required>
                            </div>
                            <div class="form-group">
                                <label for="role_name">Permissions <span class="text-danger">*</span></label>
                                <small class="text-muted">select all that apply</small>
                                <?php if (isset($all_permissions)) : ?>
                                    <fieldset>
                                        <?php foreach ($all_permissions as $value) : ?>
                                            <label for="perm_<?= $value['id'] ?>" class="bg-light border py-1 px-3 mx-1 rounded-lg single_permission_pod">
                                                <input type="checkbox" id="perm_<?= $value['id'] ?>" value="<?= $value['id'] ?>" name="permissions[]">
                                                <?= $value['perm_name'] ?>
                                            </label>
                                        <?php endforeach ?>
                                    </fieldset>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-light border" data-toggle="collapse" data-target="#newRoleCollapse"><i class="fas fa-arrow-alt-circle-left"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> submit</button>
                            </div>
                        </form>
                    </div>
                </div><!-- ./collapse -->
            </div>
            <!-- List of user roles -->
            <div class="card my-3">
                <div class="card-body">
                    <?php if (isset($roles)) : ?>
                        <?php if (count($roles) > 0) : ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Role</th>
                                            <th>actions</th>
                                            <?php foreach ($all_permissions as $permission) : ?>
                                                <th><?= $permission['perm_name'] ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($roles as $key => $role) : ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $role['role_name'] ?></td>
                                                <td><a href="<?= url_path('/users/roles/update/' . $role['id']) ?>" class="btn btn-light border"><i class="fas fa-edit"></i> edit</a></td>
                                                <?php
                                                $role_perms = getRolePermissions($role['id']);
                                                foreach ($all_permissions as $permission) {
                                                    if (in_array($permission['perm_name'], $role_perms)) {
                                                        echo '<td class="text-success text-center"><i class="fas fa-check"></i></td>';
                                                    } else {
                                                        echo '<td class="text-center"><i class="fas fa-times"></i></td>';
                                                    }
                                                }

                                                ?>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <?php alert("No users registered, users will be displayed here once available", "info") ?>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div><!-- ./card -->
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