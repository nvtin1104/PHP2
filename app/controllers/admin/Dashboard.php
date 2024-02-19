<?php
class Dashboard extends Controller
{
    public $dashboard_model, $data;
    public function __construct()
    {
        $this->dashboard_model = $this->model('HomeModel');
    }
    function index()
    {
        $data = $this->dashboard_model->getFullOder();
        $countUser = $this->dashboard_model->getFullUser();
        $revenue = 0;
        $quantity = 0;
        $orderPending = 0;
        foreach ($data as $key => $item) {
            $quantity++;
            $revenue += $item['total_price'];
            if ($item['status'] == 0) {
                $orderPending++;
            }
        }
        $this->data['sub_content']['revenue'] = $revenue;
        $this->data['sub_content']['countUser'] = $countUser;
        $this->data['sub_content']['quantityOrder'] = $quantity;
        $this->data['sub_content']['orderPending'] = $orderPending;
        $this->data['content'] = 'admin/dashboard/dashboard';
        $this->render('layout/admin_layout', $this->data);
    }
}
