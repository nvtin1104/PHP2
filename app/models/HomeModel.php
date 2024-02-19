<?php
class HomeModel extends Model
{
    protected $table = 'user';

    function tableFill()
    {
        return 'user';
    }
    function fieldFill()
    {
        return '*';
    }
    function primaryKey()
    {
        return 'id';
    }
    public function getNewProduct($limit, $offset = 0)
    {
        $date = new DateTime();
        $date->modify('-30 days');
        $ruleDate = $date->format('Y-m-d H:i:s');
        $result = $this->db->table('products')->where('create_at', '>', $ruleDate)->limit($limit, $offset)->get();
        foreach ($result as $key => $item) {
            $imgList = $this->db->table('product_img')->where('product_id', '=', $item['id'])->get();
            $result[$key]['imgList'] = $imgList;
        }
        return $result;
    }
    public function getSaleProduct($limit, $offset = 0)
    {
        $result = $this->db->table('products')->where('sale', '=', 'true')->limit($limit, $offset)->get();
        foreach ($result as $key => $item) {
            $imgList = $this->db->table('product_img')->where('product_id', '=', $item['id'])->get();
            $result[$key]['imgList'] = $imgList;
        }
        return $result;
    }
    public function getFullOder(){
        $result = $this->db->table('orders')->get();
        return $result;
    }
    public function getFullUser(){
        $result = $this->db->query("SELECT * FROM user ")->rowCount();
        return $result;
    }
    public function getOrderWithDate($date){
        $result = $this->db->table('orders')->where('create_at', '>=', $date)->orderBy('create_at', 'DESC')->get();
        return $result;
    }
}
?>