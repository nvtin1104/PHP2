<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">{{$blog['title']}}</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="/">Trang chủ</a></li>
                                <li class="active" aria-current="page">{{$blog['title']}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Blog Single Section:::... -->
<div class="blog-section">
    <div class="container">
        <div class="row flex-column-reverse flex-lg-row-reverse">
            <div class="col-lg-12">
                <!-- Start Blog Single Content Area -->
                <div class="blog-single-wrapper">
                    <div class="blog-single-img" data-aos="fade-up" data-aos-delay="0">
                        <img class="img-fluid" src="<?php echo _WEB_ROOT . $blog['img'] ?> " alt="">
                    </div>
                    <ul class="post-meta" data-aos="fade-up" data-aos-delay="200">
                        <li>Người đăng : <a href="#" class="author">{{$blog['author']}}</a></li>
                        <li>Ngày : <a href="#" class="date">{{$blog['create_at']}}</a></li>
                    </ul>
                    <h4 class="post-title" data-aos="fade-up" data-aos-delay="400">{{$blog['title']}}</h4>
                    <div class="para-content" data-aos="fade-up" data-aos-delay="600">
                        <?php
                        $comment = $blog['comment'];
                        $encodedString = html_entity_decode($blog['content'], ENT_QUOTES, 'UTF-8');
                        echo $encodedString;
                        ?>
                    </div>
                    <div class="para-tags" data-aos="fade-up" data-aos-delay="0">
                        <span>Tags: </span>
                        <ul>
                            <li><a href="#">fashion</a></li>
                            <li><a href="#">t-shirt</a></li>
                            <li><a href="#">white</a></li>
                        </ul>
                    </div>
                </div> <!-- End Blog Single Content Area -->
                <div class="comment-area">
                    <div class="comment-box" data-aos="fade-up" data-aos-delay="0">
                        <h4 class="title mb-4"><?php echo count($comment) ?> Bình luận</h4>
                        <!-- Start - Review Comment -->
                        <ul class="comment">
                            <?php
                            if (!empty($comment)) {
                                foreach ($comment as $item) {
                                    if ($item['reply_to'] == 0) { ?>
                                        <li class="comment-list">
                                            <div class="comment-wrapper">
                                                <!-- <div class="comment-img">
                                                    <img src="assets/images/user/image-1.png" alt="">
                                                </div> -->
                                                <div class="comment-content">
                                                    <div class="comment-content-top">
                                                        <div class="comment-content-left">
                                                            <h6 class="comment-name">{{$item['name']}}</h6>
                                                        </div>
                                                        <div class="comment-content-right">
                                                            <a class="reply-btn" href="#comment-form" data-id="<?php echo $item['id'] ?>" data-name="<?php echo $item['name'] ?>"><i class="fa fa-reply"></i>Trả lời</a>
                                                        </div>
                                                    </div>

                                                    <div class="para-content">
                                                        <p>{{$item['content']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Start - Review Comment Reply-->
                                            <ul class="comment-reply">
                                                <?php
                                                foreach ($comment as $item_reply) {
                                                    if ($item_reply['reply_to'] == $item['id']) { ?>
                                                        <li class="comment-reply-list">
                                                            <div class="comment-wrapper">
                                                                <!-- <div class="comment-img">
                                                                    <img src="assets/images/user/image-2.png" alt="">
                                                                </div> -->
                                                                <div class="comment-content">
                                                                    <div class="comment-content-top">
                                                                        <div class="comment-content-left">
                                                                            <h6 class="comment-name">{{$item_reply['name']}}</h6>
                                                                        </div>
                                                                        <div class="comment-content-right">
                                                                            <a class="reply-btn" href="#comment-form" data-id="<?php echo $item['id'] ?>" data-name="<?php echo $item_reply['name'] ?>"><i class="fa fa-reply"></i>Trả lời</a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="para-content">
                                                                        <p>{{$item_reply['content']}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul> <!-- End - Review Comment Reply-->
                                        </li>
                            <?php }
                                }
                            }
                            ?>
                            <!-- Start - Review Comment list-->
                            <!-- End - Review Comment list-->
                        </ul> <!-- End - Review Comment -->
                    </div>

                    <!-- Start comment Form -->
                    <div class="comment-form" data-aos="fade-up" data-aos-delay="0">
                        <div class="coment-form-text-top mt-30">
                            <h4 class="title mb-3 mt-3">Leave a Trả lời</h4>
                            <p>Your email address will not be published. Required fields are marked *</p>
                        </div>

                        <form id="comment-form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="default-form-box mb-20">
                                        <label for="comment-name">Tên của bạn<span>*</span></label>
                                        <input id="comment-name" type="text" placeholder="Tên tôi là ...">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="default-form-box mb-20">
                                        <label for="comment-email">Email <span>*</span></label>
                                        <input id="comment-email" type="text" placeholder="Email...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="default-form-box mb-20 row">
                                        <div class="col-md-8">
                                            <label for="comment-reply">Trả lời cho <span>*</span></label>
                                            <input id="comment-reply" type="text" disabled placeholder="reply...">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <button id="btn-remove-reply" class="btn mt-5 btn-md btn-golden" type="button">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box mb-20">
                                        <label for="comment-review-text">Bình luận <span>*</span></label>
                                        <textarea id="comment-review-text" placeholder="Viết bình luận tại đây"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button id="blog-btn-form" data-id="<?php echo $blog['id'] ?>" data-path=<?php echo _WEB_ROOT ?> class="btn btn-md btn-golden" type="submit">Bình luận</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- End comment Form -->
                </div>
            </div>
        </div>
    </div>
</div>