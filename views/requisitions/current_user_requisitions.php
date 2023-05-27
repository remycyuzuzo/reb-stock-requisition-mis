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
                    <h1 class="m-0">My Requisitions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">My Requisitions</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- List of user roles -->
            <div class="card my-3">
                <div class="card-body">
                    <?php if (isset($requisition_arr)) : ?>
                        <?php if (count($requisition_arr) > 0) : ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th>#</th>
                                        <th>Reference code</th>
                                        <th>Date</th>
                                        <th>status</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($requisition_arr as $requisition) : ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $requisition['req_reference_code'] ?></td>
                                                <td><?= $requisition['datetime_created'] ?></td>
                                                <td>
                                                    <span class="badge badge-<?php
                                                                                if ($requisition['status'] === 'pending') echo 'warning';
                                                                                elseif ($requisition['status'] === 'approved') echo 'info';
                                                                                elseif ($requisition['status'] === 'authorized') echo 'primary';
                                                                                elseif ($requisition['status'] === 'rejected') echo 'danger';
                                                                                ?>">
                                                        <?= $requisition['status'] ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <?php alert("You have not made any requisition yet, yours will be displayed here.", "info") ?>
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