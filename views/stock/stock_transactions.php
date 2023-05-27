<?php

$page_title = "Recent Stock transactions - " . APP_TITLE;

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
                    <h1 class="m-0">Recent transactions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= url_path('/stock') ?>">stock</a></li>
                        <li class="breadcrumb-item active">Stock Transactions</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="filters mb-2">
                <a href="#" class="btn btn-light border"><i class="fas fa-filter"></i> filters</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php if (isset($transactions)) : ?>
                        <?php $i = 1;
                        if (is_array($transactions) && count($transactions) > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>Value (in Frw)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-info">
                                No transactions found
                            </div>
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