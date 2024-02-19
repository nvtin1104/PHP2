<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Dashboard</h1>

        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
            <div class="inner">
                <div class="app-card-body p-3 p-lg-4">
                    <h3 class="mb-3">Chào ngày mới!</h3>
                    <div class="row gx-5 gy-3">
                        <div class="col-12 col-lg-9">

                            <div>Hãy tự tin và không ngừng nỗ lực trong mỗi cuộc gặp gỡ hôm nay, bởi bạn có khả năng biến mọi khách hàng thành người ủng hộ trung thành của bạn!</div>
                        </div><!--//col-->
                        <div class="col-12 col-lg-3">
                            <a class="btn app-btn-primary" href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                                    <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z" />
                                    <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z" />
                                </svg>Đi tới đơn hàng!</a>
                        </div><!--//col-->
                    </div><!--//row-->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div><!--//app-card-body-->

            </div><!--//inner-->
        </div><!--//app-card-->

        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Tổng danh thu</h4>
                        <div class="stats-figure"><?php echo number_format($revenue, 0) . ' VND'; ?></div>
                        <!-- <div class="stats-meta text-success">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                            </svg> 20%
                        </div> -->
                    </div><!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div><!--//app-card-->
            </div><!--//col-->

            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Người dùng</h4>
                        <div class="stats-figure"><?php echo $countUser ?></div>
                        <!-- <div class="stats-meta text-success">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                            </svg> 5%
                        </div> -->
                    </div><!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div><!--//app-card-->
            </div><!--//col-->
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Đơn hàng</h4>
                        <div class="stats-figure">{{$quantityOrder}}</div>
                        <!-- <div class="stats-meta">
                            Tiếp cận</div> -->
                    </div><!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div><!--//app-card-->
            </div><!--//col-->
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Đơn chưa xử lý</h4>
                        <div class="stats-figure">{{$orderPending}}</div>
                        <!-- <div class="stats-meta">MỚI</div> -->
                    </div><!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div><!--//app-card-->
            </div><!--//col-->
        </div><!--//row-->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Biểu đồ đường</h4>
                            </div><!--//col-->
                            <div class="col-auto">
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="chart-container">
                            <canvas id="canvas-linechart"></canvas>
                        </div>
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Biểu đồ cột</h4>
                            </div><!--//col-->
                            <div class="col-auto">
                                <div class="card-header-action">
                                </div><!--//card-header-actions-->
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="mb-3 d-flex">

                        </div>
                        <div class="chart-container">
                            <canvas id="canvas-barchart"></canvas>
                        </div>
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->

        </div>
    </div><!--//container-fluid-->
</div><!--//app-content-->