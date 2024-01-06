<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Bài viết</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="/">Trang chủ</a></li>
                                <li class="active" aria-current="page"><a href="/blogs">Bài viết</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Blog List Section:::... -->
<div class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog-wrapper">
                    <div class="row mb-n6">
                        <?php
                        if (!empty($list)) {
                            foreach ($list as $item) {
                        ?>
                                <div class="col-xl-4 col-md-6 col-12 mb-6">
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-list blog-grid-single-item blog-color--golden" data-aos="fade-up" data-aos-delay="0">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid" src="<?php echo _WEB_ROOT . $item['img'] ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <ul class="post-meta">
                                                <li>Người đăng : <a href="#" class="author">{{$item['author']}}</a></li>
                                                <li>Ngày : <a href="#" class="date">{{$item['create_at']}}</a></li>
                                            </ul>
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">{{$item['title']}}</a>
                                            </h6>
                                            <!-- <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p> -->
                                            <a href="#" class="read-more-btn icon-space-left">Đọc thêm<span class="icon"><i class="ion-ios-arrow-thin-right"></i></span></a>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Start Pagination -->
                <div class="page-pagination text-center" data-aos="fade-up" data-aos-delay="0">
                    <ul>
                        <li><a class="active" href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="ion-ios-skipforward"></i></a></li>
                    </ul>
                </div> <!-- End Pagination -->
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Blog List Section:::... -->