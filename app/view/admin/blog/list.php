<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Danh sách bài viết</h1>
                <?php if (!empty($delete_success)) {
                    echo '<span style="color:green;">' . $delete_success . '</span>';
                }
                if (!empty($delete_error)) {
                    echo '<span style="color:red;">' . $delete_error . '</span>';
                }
                ?>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            <form class="table-search-form row gx-1 align-items-center">
                                <div class="col-auto">
                                    <input type="text" id="search-orders" name="searchorders" class="form-control  search-orders" placeholder="Tìm gì đó...">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn app-btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg></button>
                                </div>
                            </form>

                        </div><!--//col-->
                        <div class="col-auto">

                            <select class="form-select w-auto">
                                <option selected value="option-1">All</option>
                                <option value="option-2">Tuần này</option>
                                <option value="option-3">This month</option>
                                <option value="option-4">Last 3 months</option>

                            </select>
                        </div>
                        <div class="col-auto">
                            <a class="btn app-btn-secondary" href="<?php echo _WEB_ROOT ?>/admin/blog/add">
                                Thêm bài viết mới
                            </a>
                        </div>
                    </div><!--//row-->
                </div><!--//table-utilities-->
            </div><!--//col-auto-->
        </div><!--//row-->

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Id</th>
                                        <th class="cell">Hình ảnh</th>
                                        <th class="cell">Tên sản phẩm</th>
                                        <th class="cell">Ngày</th>
                                        <th class="cell">Tác giả</th>
                                        <th class="cell">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($list)) {

                                        foreach ($list as $item) {
                                    ?>
                                            <tr>
                                                <td class="cell">{{$item['id']}}</td>
                                                <td class="cell">
                                                    <img class="profile-image m-1" style="height:50px; width=50px;" src=<?php echo _WEB_ROOT . $item['img']; ?> alt="">
                                                </td>
                                                <td class="cell"><span class="truncate">{{$item['title']}}</span></td>
                                                <td class="cell">{{$item['create_at']}}</td>
                                                <td class="cell">{{$item['author']}}</td>

                                                <td class="cell">
                                                    <a class="btn-sm app-btn-secondary" href="<?php echo _WEB_ROOT . '/admin/blog/view?id=' . $item['id'] ?>">Xem</a>
                                                    <a class="btn-sm app-btn-secondary bg-danger text-white" href="#" onclick="confirmDelete('<?php echo _WEB_ROOT . '/admin/blog/delete?id=' . $item['id'] ?>')">Xóa</a>
                                                </td>
                                            </tr>
                                    <?php  }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->

                    </div><!--//app-card-body-->
                </div><!--//app-card-->
                <?php
                $next = $page + 1;
                $pre = $page - 1;
                ?>
                <nav class="app-pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php
                                                if ($page == 1) {
                                                    echo 'disabled';
                                                }
                                                ?>">
                            <a class="page-link" href="<?php echo _WEB_ROOT . '/admin/blog/list?page=1' ?>" tabindex="-1" aria-disabled="true">Đầu</a>
                        </li>
                        <li class="page-item <?php
                                                if ($pre == 0) {
                                                    echo 'disabled';
                                                }
                                                ?>">
                            <a class="page-link" href="<?php echo _WEB_ROOT . '/admin/blog/list?page=' . $pre ?>" tabindex="-1" aria-disabled="true">Trước</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="<?php echo _WEB_ROOT . '/admin/blog/list?page=' . $page ?>"><?php echo $page ?></a></li>
                        <li class="page-item">
                            <a class="page-link <?php
                                                if ($page == $maxPage || $maxPage == 0) {
                                                    echo 'disabled';
                                                }
                                                ?>" href="<?php echo _WEB_ROOT . '/admin/blog/list?page=' . $next ?>">Tiếp</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link <?php
                                                if ($page == $maxPage || $maxPage == 0) {
                                                    echo 'disabled';
                                                }
                                                ?>" href="<?php echo _WEB_ROOT . '/admin/blog/list?page=' . $maxPage ?>">Cuối</a>
                        </li>
                    </ul>
                </nav><!--//app-pagination-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->
    </div><!--//container-fluid-->
</div><!--//app-content-->