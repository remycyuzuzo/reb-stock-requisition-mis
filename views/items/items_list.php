<?php

$page_title = "Items - " . APP_TITLE;

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
                    <h1 class="m-0">Items</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url_path('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Items</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <a href="#" class="btn btn-warning" data-toggle="collapse" data-target="#newItemCollapse"><i class="fas fa-plus-circle"></i> New Item</a>
            <hr />
            <div class="collapse user-role-form <?= has('error') ? 'show' : '' ?>" id="newItemCollapse">
                <?php if (has('error')) flash_show() ?>
                <div class="my-2 row justify-content-center">
                    <div class="col-sm-10 col-md-6 col-xl-5">
                        <h3>Create a new item</h3>
                        <p class="text-muted">Fields marked as <span class="text-danger">*</span> are required</p>
                        <form action="<?= url_path('/items/new') ?>" method="POST" id="depForm">
                            <div class="form-group">
                                <label for="item_name">Item name <span class="text-danger">*</span></label>
                                <input type="text" id="item_name" name="item_name" class="form-control" placeholder="The name of item" required>
                            </div>
                            <div class="form-group">
                                <label for="item_category">Item category</label>
                                <select name="item_category" id="item_category" class="form-control">
                                    <option value="" disabled selected>Select the category</option>
                                    <?php if (isset($item_categories)) : ?>
                                        <?php foreach ($item_categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                <small class="text-muted">can't find a category? <a href="#" data-toggle="modal" data-target="#newCategory">make a new one</a></small>
                            </div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-light border" data-toggle="collapse" data-target="#newItemCollapse"><i class="fas fa-arrow-alt-circle-left"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> submit</button>
                            </div>
                        </form>
                    </div>
                </div><!-- ./collapse -->
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <?php if (isset($item_list)) : ?>
                        <?php if (count($item_list) > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Date created</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($item_list as $key => $item) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $item['item_name'] ?></td>
                                            <td><?= $item['category_name'] ?></td>
                                            <td><?= $item['datetime_created'] ?></td>
                                            <td>
                                                <a href="" class="btn btn-light border"><i class="fas fa-edit"></i> edit</a>
                                                <a href="" class="btn btn-light border"><i class="fas fa-eye"></i> view</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php alert("No items registered, items will be displayed here once available", "info") ?>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- The Modal -->
<div class="modal" id="newCategory">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-plus-circle"></i> Create a new item category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form action="" method="post" id="newCategoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cat_name">Category name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Category name" id="cat_name" name="cat_name">
                    </div>
                    <?= csrf_token() ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-dismiss="modal">cancel</button>
                    <button type="submit" class="btn btn-primary border"><i class="fas fa-check-circle"></i> save</button>
                </div>

                <div class="results px-3"></div>

            </form>
        </div>
    </div>
</div>

<?php
include VIEWS_FOLDER . "/layouts/aside-menu.php";

include VIEWS_FOLDER . "/layouts/footer.php";

include VIEWS_FOLDER . "/layouts/foot.php"
?>
<script src="<?= STATIC_FOLDER_URL . "/assets/libs/axios/dist/axios.min.js" ?>"></script>
<script>
    (function() {
        const url = document.URL
        const urlParts = url.split('#')
        if (urlParts.includes('new-item')) {
            document.querySelector('.collapse').classList.add('show');
        }
    })();

    (function() {
        const newCategoryForm = document.querySelector('#newCategoryForm');
        if (!newCategoryForm) {
            return;
        }
        newCategoryForm.onsubmit = e => {
            document.querySelector('#newCategoryForm button[type=submit]').disabled = true;
            e.preventDefault();
            const data = new FormData(newCategoryForm);
            axios.post('<?= url_path('/items/new/category') ?>', data)
                .then(response => {
                    if (response.data.result) {
                        // display an alert
                        document.querySelector('.results').innerHTML = `
                            <div class="alert alert-success">${response.data.message}</div>
                        `;
                        // auto add and select to the select element
                        const drpSelect = document.querySelector('select#item_category');
                        const option = document.createElement('option');
                        const txt = document.createTextNode(`${data.get('cat_name')}`);
                        option.selected = true;
                        option.value = (`${response.data.newID}`)
                        option.appendChild(txt);
                        drpSelect.appendChild(option)
                    } else {
                        document.querySelector('.results').innerHTML = `
                            <div class="alert alert-danger">${response.data.message}</div>
                        `;
                    }
                })
                .then(() => {
                    document.querySelector('#newCategoryForm button[type=submit]').disabled = false;
                })
                .catch(err => console.warn(err))
        }
    })();
</script>