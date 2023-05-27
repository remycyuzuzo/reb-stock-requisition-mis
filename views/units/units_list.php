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
                    <h1 class="m-0">Units</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Units</li>
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
            <a href="#" title="Create a new user group/role" class="btn btn-warning" data-toggle="collapse" data-target="#newRoleCollapse"><i class="fas fa-plus-circle"></i> New unit</a>
            <hr />
            <div class="collapse user-role-form <?= has('error') ? 'show' : '' ?>" id="newRoleCollapse">
                <?php if (has('error')) flash_show() ?>
                <div class="my-2 row justify-content-center">
                    <div class="col-sm-10 col-md-6 col-xl-5">
                        <h3>Create a new user group</h3>
                        <p class="text-muted">Fields marked as <span class="text-danger">*</span> are required</p>
                        <form action="<?= url_path('/units/new-unit') ?>" method="POST" id="unitForm">
                            <div class="form-group">
                                <label for="unit_name">Unit name <span class="text-danger">*</span></label>
                                <input type="text" id="unit_name" name="unit_name" class="form-control" placeholder="The name of the unit" required>
                            </div>
                            <div class="form-group">
                                <label for="dep">Department <span class="text-danger">*</span></label>
                                <select name="department" id="dep" class="form-control" required>
                                    <option value="" disabled selected>Select the department</option>
                                    <?php if (isset($department_list)) : ?>
                                        <?php foreach ($department_list as $department) : ?>
                                            <option value="<?= $department['id'] ?>"><?= $department['dep_name'] ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-light border" data-toggle="collapse" data-target="#newRoleCollapse"><i class="fas fa-arrow-alt-circle-left"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> submit</button>
                            </div>
                        </form>
                    </div>
                </div><!-- ./collapse -->
            </div>
            <!-- List of units -->
            <div class="card my-3">
                <div class="card-body">
                    <?php if (isset($units)) : ?>
                        <?php if (count($units) > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unit name</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($units as $key => $unit) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $unit['unit_name'] ?></td>
                                            <td>
                                                <a href="" class="btn btn-light border"><i class="fas fa-edit"></i> edit</a>
                                                <a href="" class="btn btn-light border"><i class="fas fa-eye"></i> view</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php alert("No units available to display available", "info") ?>
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
    $('#unitForm').validate({
        rules: {
            email: {
                email: true,
                required: true,
            }

        }
    });