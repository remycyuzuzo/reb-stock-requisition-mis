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
                    <h1 class="m-0">User management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <a href="<?= url_path('/users/new-user') ?>" class="btn btn-warning"><i class="fas fa-plus-circle"></i> New user</a>
            <hr />
            <div class="card my-3">
                <div class="card-body">
                    <?php if (isset($users)) : ?>
                        <?php if (count($users) > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full name</th>
                                        <th>Email address</th>
                                        <th>Role</th>
                                        <th>status</th>
                                        <th>last sign-in</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($users as $key => $user) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                                            <td><?= $user['email_addr'] ?></td>
                                            <td><?= $user['role_name'] ?></td>
                                            <td><?= $user['status'] ?></td>
                                            <td><?= '' ?></td>
                                            <td>
                                                <a href="" class="btn btn-light border"><i class="fas fa-edit"></i> edit</a>
                                                <a href="" class="btn btn-light border"><i class="fas fa-eye"></i> view</a>
                                                <a href="" class="btn btn-light border"><i class="fas fa-key"></i> permissions</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php alert("No users registered, users will be displayed here once available", "info") ?>
                        <?php endif ?>
                    <?php endif ?>
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

include VIEWS_FOLDER . "/layouts/foot.php"
?>