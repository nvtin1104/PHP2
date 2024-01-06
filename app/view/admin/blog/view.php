<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Thêm bài viết </h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-9">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <form class="settings-form" action="<?php echo _WEB_ROOT ?>/admin/blog/handle_add" method="post" enctype="multipart/form-data">
                            <div class="mb-3 form-floating">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Tên sản phẩm" value="<?php echo $blog_infor['title'] ?>">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <?php echo form_error('title', '<span style="color:red;">', '</span>'); ?>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="text" class="form-control" name="meta" id="meta" placeholder="Thẻ meta" value="<?php echo $blog_infor['meta'] ?>">
                                <label for="meta" class="form-label">Thẻ meta</label>
                                <?php echo form_error('meta', '<span style="color:red;">', '</span>'); ?>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="text" class="form-control" name="author" id="author" placeholder="Tác giả" value="<?php echo $blog_infor['author'] ?>">
                                <label for="author" class="form-label">Tác giả</label>
                                <?php echo form_error('author', '<span style="color:red;">', '</span>'); ?>
                            </div>
                            <script>
                                tinymce.init({
                                    selector: 'textarea',
                                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                                });
                            </script>
                            <div class="mb-3">
                                <textarea name="content">
                                <?php echo $blog_infor['content'] ?>
                                </textarea>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-8">
                                    <input type="file" name="img" class="form-control" id="img" accept="image/*" onchange="previewImage(this, 'preview', true)">
                                </div>
                                <div class="col-md-4">
                                    <img id="preview" src="<?php echo _WEB_ROOT . $blog_infor['img'] ?>" alt="Preview Image" style="width: 100px; height: 100px; display: none;">
                                </div>

                            </div>
                            <button type="submit" class="btn app-btn-primary">Thêm sản phẩm</button>
                        </form>
                    </div><!--//app-card-body-->

                </div><!--//app-card-->
            </div>
            <div class="col-12 col-md-3">
                <h3 class="section-title">Ghi chú:</h3>
                <div class="section-intro">Nhớ thêm đầy đủ và chi tiết nhé!<br><a href="help.html">Xem thêm</a></div>
                <div>
                    <?php if (!empty($success)) {
                        echo '<span style="color:green;">' . $success . '</span>';
                    }
                    if (!empty($error)) {
                        echo '<span style="color:red;">' . $error . '</span>';
                    }
                    ?>
                </div>
            </div>

        </div><!--//row-->
    </div>