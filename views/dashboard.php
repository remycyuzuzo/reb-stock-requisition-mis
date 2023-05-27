<?php

$page_title = "";
// Include segments of the page layouts
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
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// includes the segments of te page layout
include VIEWS_FOLDER . "/layouts/aside-menu.php";
include VIEWS_FOLDER . "/layouts/footer.php";
include VIEWS_FOLDER . "/layouts/foot.php"
?>