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
                    <h1 class="m-0">Departments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Departments</li>
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
                        <h3>Create a new department</h3>
                        <p class="text-muted">Fields marked as <span class="text-danger">*</span> are required</p>
                        <form action="<?= url_path('/departments/new') ?>" method="POST" id="depForm">
                            <div class="form-group">
                                <label for="dep_name">Department name <span class="text-danger">*</span></label>
                                <input type="text" id="dep_name" name="dep_name" class="form-control" placeholder="The name of the department" required>
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
                    <?php if (isset($department_list)) : ?>
                        <?php if (count($department_list) > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($department_list as $key => $department) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $department['dep_name'] ?></td>
                                            <td>
                                                <a href="" class="btn btn-light border"><i class="fas fa-edit"></i> edit</a>
                                                <a href="" class="btn btn-light border"><i class="fas fa-eye"></i> view</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php alert("No department available to display available", "info") ?>
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
    $('#depForm').validate({
        rules: {
            email: {
                email: true,
                required: true,
            }

        }
    });