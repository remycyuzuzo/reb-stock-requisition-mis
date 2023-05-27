<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= STATIC_FOLDER_URL . "/assets/libs/fontawesome-free/css/all.min.css" ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= STATIC_FOLDER_URL . "/assets/css/adminlte.min.css" ?>">
    <link rel="stylesheet" href="<?= STATIC_FOLDER_URL . "/assets/css/mystyles.css" ?>">
    <title>Page Not Found - <?= APP_TITLE ?></title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="<?= url_path('/login') ?>"> be looking to sign in?</a>
            </p>
        </div>
        <!-- /.error-content -->
    </div>
</body>

</html>