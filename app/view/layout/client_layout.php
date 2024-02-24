<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Google tag (gtag.js) -->

    <meta name="google-site-verification" content="qBRfvOVkCqc-JyzGp1M2R90EcXmW-noLL-Qqr0hpMWw" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DQWQ3WLX6L"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-DQWQ3WLX6L');
    </script>
    <title>

        <?php
        if (!empty($page_title)) {
            echo $page_title;
        } else {
            echo 'BookShop';
        }
        ?>
    </title>

    <!-- ::::::::::::::Favicon icon::::::::::::::-->
    <link rel="shortcut icon" href="<?php echo _WEB_ROOT ?>/public/assets/client/images/favicon.ico" type="image/png">


    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/client/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/client/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/client/css/style.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/client/css/custom.css">
    <meta name="keywords" content="<?php echo $meta ?>">
    <link id="theme-style" rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/admin/css/custom.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="bg_loading">
        <div class="load-div one"></div>
        <div class="load-div two"></div>
        <div class="load-div three"></div>
        <div class="load-div four"></div>
        <div class="load-div five"></div>
    </div>
    <div class="toast-container">
        <div class="toasts"></div>
        <div class="master-toast-notification hide-toast">
            <div class="toast-content">
                <div class="toast-icon">
                    <i id="icon-toast" class="fa-solid"></i>
                </div>
                <div class="toast-msg"></div>
            </div>
            <div class="toast-progress">
                <div class="toast-progress-bar"></div>
            </div>
        </div>
    </div>
    <?php
    if (!empty($user_infor)) {
        $this->render('blocks/header', $user_infor);
    } else  $this->render('blocks/header');
    $this->render($content, $sub_content);
    $this->render('blocks/footer');
    ?>
    <button class="material-scrolltop" type="button"></button>

    <!-- Start Modal Add cart -->
    <div class="modal fade" id="modalAddcart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col text-right">
                                <button type="button" class="close modal-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="modal-add-cart-product-img">
                                            <img class="img-fluid" src="<?php echo _WEB_ROOT ?>/public/assets/client/images/product/default/home-1/default-1.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="modal-add-cart-info"><i class="fa fa-check-square"></i>Thêm vào giỏ hàng thành công!</div>
                                        <div class="modal-add-cart-product-cart-buttons">
                                            <a href="<?php echo _WEB_ROOT . '/cart/cart?page=1' ?>">Xem giỏ hàng</a></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 modal-border">
                                <ul class="modal-add-cart-product-shipping-info">
                                    <li> <strong><i class="icon-shopping-cart"></i> Có <strong class="modal-add-cart-product-shipping-info-quantity">0</strong> trong giỏ hàng của bạn</strong></li>
                                    <li> <strong>Tổng giá tiền: </strong> <span class="modal-add-cart-product-shipping-info-price">$187.00</span></li>
                                    <li class="modal-continue-button"><a href="#" data-bs-dismiss="modal">Tiếp tục mua sắm</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Modal Add cart -->
    <input type="hidden" data-route="<?php echo _WEB_ROOT ?>" id="root-route">
    <!-- Start Modal Quickview cart -->

    <!-- End Modal Quickview cart -->
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/client/js/vendor/vendor.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/client/js/plugins/plugins.min.js"></script>
    <!-- Main JS -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/client/js/main.js"></script>
    <!-- <script src="<?php echo _WEB_ROOT ?>/public/lib/node_modules/jquery/dist/jquery.min.js"></script> -->
    <script>
        $(document).ready(function() {
            let toastCounter = 1;
            const toast = {
                success: {
                    icon: "fa-check",
                    color: "#27ae60",
                    animation: "slide-in-slide-out"
                },
                error: {
                    icon: "fa-triangle-exclamation",
                    color: "#c0392b",
                    animation: "slide-in-fade-out"
                },
                info: {
                    icon: "fa-info",
                    color: "#2980b9",
                    animation: "slide-in-slide-out"
                },
                warning: {
                    icon: "fa-triangle-exclamation",
                    color: "#f39c12",
                    animation: "slide-in-fade-out"
                }
            };

            function displayToastNotification(msg, type) {
                let class_name = 'toast-' + toastCounter;
                let new_node;
                let htmlToast = toast[type];
                let icon = $('#icon-toast');
                icon.addClass(htmlToast.icon);
                console.log(icon);
                new_node = $('.master-toast-notification').clone().appendTo('.toasts').addClass(class_name + ' toast-notification').removeClass('master-toast-notification');
                new_node.find('.toast-msg').text(msg);
                new_node.find('.toast-icon').addClass('wiggle-me').css('background-color', htmlToast.color);
                new_node.removeClass('hide-toast').addClass(htmlToast.animation);
                setTimeout(function() {
                    new_node.remove();
                }, 3800);
                toastCounter++;
            }
            $('#bg_loading').hide();
            $("#registerBtn").click(function(event) {
                event.preventDefault();
                var username = $("#username").val();
                var password = $("#password").val();
                var email = $("#email").val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo _WEB_ROOT ?>/auth/register",
                    data: {
                        username: username,
                        password: password,
                        email: email
                    },
                    dataType: "json", // Loại dữ liệu mà bạn mong đợi từ máy chủ
                    beforeSend: function() {
                        // Thêm hiệu ứng loading tại đây (ví dụ: hiển thị một biểu tượng loading)
                        $("#bg_loading").show();
                    },
                    success: function(response) {
                        $("#bg_loading").hide();
                        if (response.error) {
                            // Hiển thị thông báo lỗi
                            displayToastNotification(response.error, 'error');
                        } else if (response.success) {
                            // Hiển thị thông báo thành công
                            displayToastNotification(response.success, 'success');
                            setTimeout(function() {
                                window.location.href = url + "/home";
                            }, 2000); // 5 seconds
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#bg_loading").hide();
                        // Xử lý lỗi AJAX (nếu có)
                        console.error("Lỗi AJAX: " + status + " - " + error);
                    }
                });
            });
            $("#loginBtn").click(function(event) {
                event.preventDefault();
                var username = $("#username-login").val();
                var password = $("#password-login").val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo _WEB_ROOT ?>/auth/login",
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: "json", // Loại dữ liệu mà bạn mong đợi từ máy chủ
                    beforeSend: function() {
                        // Thêm hiệu ứng loading tại đây (ví dụ: hiển thị một biểu tượng loading)
                        $("#bg_loading").show();
                    },
                    success: function(response) {
                        $("#bg_loading").hide();
                        if (response.error) {
                            // Hiển thị thông báo lỗi
                            displayToastNotification(response.error, 'error');
                        } else if (response.success) {
                            // Hiển thị thông báo thành công
                            displayToastNotification(response.success, 'success');
                            window.location.href = "<?php echo _WEB_ROOT ?>/home";
                        } else if (response.log) {
                            // Hiển thị thông báo thành công
                            console.log(response.log);
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#bg_loading").hide();
                        // Xử lý lỗi AJAX (nếu có)
                        console.error("Lỗi AJAX: " + status + " - " + error);
                    }
                });
            });

            $("#cfMail").click(function(event) {
                event.preventDefault();
                var token = $("#token").val();
                var email = $("#email").val();
                var path = $("#path").val();
                var id = $("#user_id").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo _WEB_ROOT ?>/Profile/cf_change_email",
                    data: {
                        token: token,
                        user_id: id,
                        email: email
                    },
                    dataType: "json", // Loại dữ liệu mà bạn mong đợi từ máy chủ
                    beforeSend: function() {
                        // Thêm hiệu ứng loading tại đây (ví dụ: hiển thị một biểu tượng loading)
                        $("#bg_loading").show();
                    },
                    success: function(response) {
                        $("#bg_loading").hide();
                        if (response.error) {
                            // Hiển thị thông báo lỗi
                            alert(response.error);
                        } else if (response.success) {
                            // Hiển thị thông báo thành công
                            alert(response.success);
                            window.location.href = "<?php echo _WEB_ROOT ?>/quan-ly-tai-khoan";
                        } else if (response.log) {
                            // Hiển thị thông báo thành công
                            console.log(response.log);
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#bg_loading").hide();
                        // Xử lý lỗi AJAX (nếu có)
                        console.error("Lỗi AJAX: " + status + " - " + error);
                    }
                });
            });
        });
        // Toast function
    </script>
    <?php
    if ($content == 'products/detail') {
        echo '<script src="' . _WEB_ROOT . '/public/assets/client/js/product.js"></script>';
    } elseif ($content == 'cart/checkout') {
        echo '<script type="module" src="' . _WEB_ROOT . '/public/assets/client/js/checkout.js"></script>';
    } elseif ($content == 'blogs/detail') {
        echo '<script src="' . _WEB_ROOT . '/public/assets/client/js/blog.js"></script>';
    } else {
        echo '<script src="' . _WEB_ROOT . '/public/assets/client/js/cart.js"></script>';
    };
    echo '<script src="' . _WEB_ROOT . '/public/assets/client/js/search.js"></script>';

    ?>
    <script type="text/javascript" src="<?php echo _WEB_ROOT ?>/public/assets/client/js/account.js"></script>


</body>

</html>