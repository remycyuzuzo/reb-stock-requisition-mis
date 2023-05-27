<?php

$page_title = "Add a new system user - REB SMS";

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
                    <h1 class="m-0">Register a new user</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?= url_path('/users') ?>">Users</a></li>
                        <li class="breadcrumb-item active">New user</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="form col-lg-6">
                    <p class="text-muted">fieds marked by <span class="text-danger">*</span> are required</p>
                    <form action="<?= url_path('/users/new-user') ?>" class="my-3" method="POST" id="newUserForm">
                        <?php csrf_token() ?>
                        <div class="form-group">
                            <label for="first_name">First name <span class="text-danger">*</span></label>
                            <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name <span class="text-danger">*</span></label>
                            <input type="text" id="last_name" class="form-control" name="last_name" placeholder="last name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                        </div>
                        <div class="form-group">
                            <label for="tel_number">Telephone number</label>
                            <input type="tel" class="form-control" id="tel_number" name="tel_number" placeholder="Telephone number">
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Create a new password for this user" required>
                        </div>
                        <div class="form-group">
                            <label for="role">User role <span class="text-danger">*</span></label>
                            <select id="role" class="form-control" name="role" required>
                                <option value="" disabled selected>Select the user role</option>
                                <?php if (isset($all_roles)) : ?>
                                    <?php foreach ($all_roles as $role) : ?>
                                        <option value="<?= $role['id'] ?>" data-userrole="<?= $role['user_role_slug'] ?>"><?= $role['role_name'] ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit <span class="text-danger">*</span></label>
                            <select id="unit" class="form-control" name="unit" required disabled>
                                <option value="" disabled selected>Select the unit</option>
                                <?php if (isset($all_units)) : ?>
                                    <?php foreach ($all_units as $unit) : ?>
                                        <option value="<?= $unit['id'] ?>"><?= $unit['unit_name'] ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="department">Department <span class="text-danger">*</span></label>
                            <select id="department" class="form-control" name="department" required disabled>
                                <option value="" disabled selected>Select the department</option>
                                <?php if (isset($all_departments)) : ?>
                                    <?php foreach ($all_departments as $department) : ?>
                                        <option value="<?= $department['id'] ?>"><?= $department['dep_name'] ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-light border" onclick="window.history.back()"><i class="fas fa-arrow-alt-circle-left"></i> Cancel</button>
                            <button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include VIEWS_FOLDER . "/layouts/aside-menu.php";

include VIEWS_FOLDER . "/layouts/footer.php";

include VIEWS_FOLDER . "/layouts/foot.php";
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

    // department | Unit enabler
    (function() {
        const role = document.querySelector('#role');
        if (!role) {
            return;
        }
        role.onchange = () => {
            const roleSelectedOption = document.querySelector('#role option:checked')
            switch (roleSelectedOption.dataset.userrole) {
                <?php global $_user_roles; ?>
                case '<?= $_user_roles['staff'] ?>':
                    document.querySelector('#unit').disabled = false;
                    document.querySelector('#department').disabled = true;
                    break;
                case '<?= $_user_roles['hod'] ?>': // Head of department
                    document.querySelector('#department').disabled = false;
                    document.querySelector('#unit').disabled = true;
                    break;
                case '<?= $_user_roles['dou'] ?>': // Director of Unit
                    document.querySelector('#department').disabled = true;
                    document.querySelector('#unit').disabled = false;
                    break;
                case '<?= $_user_roles['logistics'] ?>':
                    document.querySelector('#department').disabled = true;
                    document.querySelector('#unit').disabled = true;
                    break;
                case '<?= $_user_roles['storekeeper'] ?>':
                    document.querySelector('#department').disabled = true;
                    document.querySelector('#unit').disabled = true;
                    break;
                case '<?= $_user_roles['admin'] ?>':
                    document.querySelector('#department').disabled = true;
                    document.querySelector('#unit').disabled = false;
                    break;
            }
        }
    })()
</script>