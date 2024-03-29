<!DOCTYPE html>
<html lang="en">
<?php if (empty($sub_content)) {
    $sub_content = [];
} ?>

<head>
    <title>Admin BookShop</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin BookShop">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/fontawesome/js/all.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ob2bst5rg8fd0hqhqaxcd9fln8ydipgsidblxo0aakpn3d1c/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/admin/css/portal.css">

</head>

<body class="app">
    <!--//app-header-->
    <header>
        <?php $this->render('blocks/admin_header') ?>
    </header>
    <input type="hidden" data-route="<?php echo _WEB_ROOT ?>" id="root-route">

    <div class="app-wrapper">

        <?php $this->render($content, $sub_content); ?>

        <?php $this->render('blocks/admin_footer') ?>

    </div><!--//app-wrapper-->


    <!-- Javascript -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/popper.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Charts JS -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/chart.js/chart.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/index-charts.js"></script>

    <!-- Page Specific JS -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/app.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/admin.js"></script>

</body>

</html>