<?php

$page_title = "Pending Requisitions to approve - " . APP_TITLE;

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
                    <h1 class="m-0">Pending Requisitions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pending Requisitions</li>
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
                    <?php if (isset($requisition_list)) : ?>
                        <?php if (count($requisition_list) > 0) : ?>
                            <h3 class="mb-3">Requisitions from <?= $requisition_list[0]['dep_name'] != null ? $requisition_list[0]['dep_name'] : $requisition_list[0]['unit_name'] ?></h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th>#</th>
                                        <th>Reference code</th>
                                        <th>By</th>
                                        <th>Department</th>
                                        <th>Unit</th>
                                        <th>Date</th>
                                        <th>actions</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($requisition_list as $requisition) : ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $requisition['req_reference_code'] ?></td>
                                                <td><?= $requisition['first_name'] . " " . $requisition['last_name'] ?></td>
                                                <td><?= $requisition['dep_name'] ?></td>
                                                <td><?= $requisition['unit_name'] ?></td>
                                                <td><?= $requisition['datetime_created'] ?></td>
                                                <td>
                                                    <a href="" class="btn btn-light border"><i class="fas fa-eye"></i> View</a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-secondary">
                                There are no new requests from your department/unit
                            </div>
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