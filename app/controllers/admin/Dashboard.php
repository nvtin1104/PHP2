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
            if ($item['status'] == 1) {
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
    public function chart()
    {
        $before7Day = date('Y-m-d H:i:s', strtotime('-7 days'));
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $week[] = date('m-d', strtotime("-$i days"));
        }
        $week = array_reverse($week);

        $order7Day = $this->dashboard_model->getOrderWithDate($before7Day);
        $orderInWeek = [];
        foreach ($week as $dayInWeek) {
            $count = 0;
            foreach ($order7Day as $infor) {
                $dayOrder = date('m-d', strtotime($infor['create_at']));
                if ($dayOrder == $dayInWeek) {
                    $count++;
                }
            }

            $orderInWeek[] = $count;
        }
        $revenueInWeek = [];
        $revenueRealInWeek = [];

        foreach ($week as $dayInWeek) {
            $count = 0;
            $countReal = 0;
            foreach ($order7Day as $infor) {
                $dayOrder = date('m-d', strtotime($infor['create_at']));

                if ($dayOrder == $dayInWeek) {
                    $count = $count + $infor['total_price'];
                    if ($infor['status'] == 4) {
                        $countReal = $countReal + $infor['total_price'];
                    }
                }
            }
            $revenueRealInWeek[] = $countReal;
            $revenueInWeek[] = $count;
        }
        $dataBarchart = [
            'week' => $week,
            'orderInWeek' => $orderInWeek
        ];
        $dataLinechart = [
            'week' => $week,
            'revenueInWeek' => $revenueInWeek,
            'revenueRealInWeek' => $revenueRealInWeek,
        ];
        $dataReturn = [
            'dataBarchart'  => $dataBarchart,
            'dataLinechart' => $dataLinechart
        ];

        $jsonString = json_encode($dataReturn);
        // In ra chuỗi JSON
        echo $jsonString;
    }
}
?>