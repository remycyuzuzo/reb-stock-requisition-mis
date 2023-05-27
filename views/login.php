<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= STATIC_FOLDER_URL . "/assets/css/adminlte.min.css" ?>">
    <link rel="stylesheet" href="<?= STATIC_FOLDER_URL . "/assets/libs/fontawesome-free/css/all.min.css" ?>">
    <title>Login REB</title>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-header text-center">
                <h3><?= APP_TITLE ?></h3>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php if (has('error') || has('warn')) {
                    flash_show();
                }
                ?>
                <form action="<?= url_path("/login") ?>" method="post">
                    <?php csrf_token() ?>
                    <?php if (isset($_GET['redirect_to'])) : ?>
                        <input type="hidden" name="redirect_to" value="<?= $_GET['redirect_to'] ?>">
                    <?php endif ?>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email_addr" required autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in"></i> Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="my-2">
                        Forgot your password? <a href="">Reset it here</a>
                    </div>


                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</body>

<script>
    const alert = document.querySelector('.alert-dismissible');
    if (alert) {
        document.querySelector('.alert-dismissible .close').onclick = (e) => {
            alert.remove();
        }
    }
</script>

<!-- jQuery -->
<script src="<?= STATIC_FOLDER_URL . "/assets/libs/jquery/jquery.min.js" ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= STATIC_FOLDER_URL . "/assets/libs/bootstrap/js/bootstrap.bundle.min.js" ?>"></script>
<!-- AdminLTE App -->
<script src="<?= STATIC_FOLDER_URL . "/assets/js/adminlte.min.js" ?>"></script>

</html>