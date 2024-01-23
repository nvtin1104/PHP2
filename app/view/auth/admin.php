<div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4">
                    <a href="/"><img src=" <?php echo _WEB_ROOT ?>/public/assets/client/images/logo/logo_black.png" alt=""></a>
                </div>
                <h2 class="auth-heading text-center mb-5">Đăng nhập quản trị</h2>
                <div class="auth-form-container text-start">
                    <form class="auth-form login-form">
                        <div class="email mb-3">
                            <label class="sr-only" for="signin-email">Email hoặc tên đăng nhập</label>
                            <input id="signin-email" name="signin-email" type="text" class="form-control signin-email" placeholder="Tên đăng nhập/ Email" required="required">
                        </div><!--//form-group-->
                        <div class="password mb-3">
                            <label class="sr-only" for="signin-password">Mật khẩu</label>
                            <input id="signin-password" name="signin-password" type="password" class="form-control signin-password" placeholder="Mật khẩu" required="required">
                            <div class="extra mt-3 row justify-content-between">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <div class="forgot-password text-end">
                                        <a href="auth/quen-mat-khau">Quên mật khẩu?</a>
                                    </div>
                                </div><!--//col-6-->
                            </div><!--//extra-->
                        </div><!--//form-group-->
                        <div class="text-center">
                            <button type="submit" id="loginAdminBtn" data-url="<?php echo _WEB_ROOT ?>" class="btn app-btn-primary w-100 theme-btn mx-auto">Đăng nhập</button>
                        </div>
                    </form>

                </div><!--//auth-form-container-->

            </div><!--//auth-body-->

            <footer class="app-auth-footer">
                <div class="container text-center py-3">
                    <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                    <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>

                </div>
            </footer><!--//app-auth-footer-->
        </div><!--//flex-column-->
    </div><!--//auth-main-col-->
    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder">
        </div>
        <div class="auth-background-mask"></div>
        <div class="auth-background-overlay p-3 p-lg-5">
            <div class="d-flex flex-column align-content-end h-100">
                <div class="h-100"></div>
                <div class="overlay-content p-3 p-lg-4 rounded">
                    <h5 class="mb-3 overlay-title">Book Shop BMT</h5>
                    <div>Đăng nhập để quản trị.</div>
                </div>
            </div>
        </div><!--//auth-background-overlay-->
    </div><!--//auth-background-col-->

</div><!--//row-->