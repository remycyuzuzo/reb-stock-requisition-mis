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
                    <h1 class="m-0">Stock</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Stock</li>
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
                <a href="#" class="btn btn-light border" data-toggle="collapse" data-target="#filters"><i class="fas fa-filter"></i> filters</a>
                <div class="my-2 collapse" id="filters">
                    <h3>Filters</h3>
                    <form action="<?= url_path('/stock') ?>" method="get">
                        <select name="filter" id="filter">
                            <option value="">Select the type of filter</option>
                            <option value="weekly">weekly</option>
                            <option value="monthly">monthly</option>
                            <option value="annually">annually</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php if (isset($stock)) : ?>
                        <?php $i = 1;
                        if (is_array($stock) && count($stock) > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Value (in Frw)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stock as $stockItem) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $stockItem['item_name'] ?></td>
                                            <td><?= $stockItem['category_name'] ?></td>
                                            <td><?= $stockItem['quantity'] ?></td>
                                            <td><?= '' ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-info">
                                No item found
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