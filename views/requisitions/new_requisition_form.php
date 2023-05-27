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
                    <h1 class="m-0">Materials Requisition form</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">New Requisition</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="<?= url_path('/requisitions/add-to-list') ?>" method="post" class="mb-2">
                <fieldset class="border p-2 rounded-lg" style="border-width: 3px!important;">
                    <legend class="w-auto bg-secondary rounded-pill px-3">
                        <span class="mb-0">Requisition form</span>
                    </legend>
                    <small class="text-muted">You can add as many items as you want</small>
                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="item_id">Item</label>
                                <select name="item_id" id="item_id" class="form-control" <?= (isset($_SESSION['temp_update']) && ($item['id'] === $_SESSION['temp_update']['id'])) ? 'disabled' : '' ?> required>
                                    <option value="" disabled selected>Select the item</option>
                                    <?php if (isset($item_list)) : ?>
                                        <?php foreach ($item_list as $item) : ?>
                                            <option value="<?= $item['id'] ?>" <?= (isset($_SESSION['temp_update']) && ($item['id'] === $_SESSION['temp_update']['id'])) ? 'selected' : '' ?>><?= $item['item_name'] ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="quantity">Item quantity</label>
                                <input type="number" placeholder="Number of items" value="<?= (isset($_SESSION['temp_update']) && ($item['id'] === $_SESSION['temp_update']['id'])) ? $_SESSION['temp_update']['quantity'] : '' ?>" name="quantity" id="quantity" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="comments">additional comments</label>
                                <textarea placeholder="any comment?" name="comments" id="comments" class="form-control"><?= (isset($_SESSION['temp_update']) && ($item['id'] === $_SESSION['temp_update']['id'])) ? $_SESSION['temp_update']['comments'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3 align-self-center">
                            <div class="form-group">
                                <button class="btn btn-secondary">
                                    <i class="fas fa-plus-circle"></i>
                                    <?= isset($_SESSION['temp_update']) ? 'update items' : 'add to the list' ?>
                                </button>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </form>
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($req_temp_list)) : ?>
                            <?php if (count($req_temp_list) > 0) : ?>
                                <div class="d-flex justify-content-between">
                                    <h3>your requisition items</h3>
                                    <form action="<?= url_path('/requisitions/new') ?>" method="post">
                                        <?php
                                        if (has('error')) {
                                            flash_show();
                                        }
                                        ?>
                                        <?php csrf_token() ?>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Submit your requisition</button>
                                        <a href="<?= url_path('/requisitions/new/form/clear-list') ?>" class="btn btn-warning"><i class="fas fa-trash"></i> Clear</a>
                                    </form>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Comment</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($req_temp_list as $requisition) : ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $requisition['item_name'] ?></td>
                                                <td><?= $requisition['quantity'] ?></td>
                                                <td><?= $requisition['comments'] ?></td>
                                                <td>
                                                    <a href="<?= url_path("/requisitions/new/form/remove/$requisition[id]") ?>" class="btn btn-light btn-sm border"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <?php alert("empty list, use the form to add some!", "info") ?>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
if (isset($_SESSION['temp_update'])) {
    unset($_SESSION['temp_update']);
}

include VIEWS_FOLDER . "/layouts/aside-menu.php";

include VIEWS_FOLDER . "/layouts/footer.php";

include VIEWS_FOLDER . "/layouts/foot.php"
?>