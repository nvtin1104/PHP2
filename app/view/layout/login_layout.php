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
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/fontawesome/js/all.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ob2bst5rg8fd0hqhqaxcd9fln8ydipgsidblxo0aakpn3d1c/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/admin/css/portal.css">

</head>

<body class="app app-login p-0">
    <!--//app-header-->
    <?php $this->render($content, $sub_content); ?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Javascript -->
<script src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/popper.min.js"></script>
<script src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Charts JS -->
<script src="<?php echo _WEB_ROOT ?>/public/assets/admin/plugins/chart.js/chart.min.js"></script>
<script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/index-charts.js"></script>

<!-- Page Specific JS -->
<script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/app.js"></script>
<script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/login.js"></script>

</html>