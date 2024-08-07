<?php
class CartModel extends Model
{
    protected $table = 'cart_items';

    function tableFill()
    {
        return 'cart_items';
    }
    function fieldFill()
    {
        return '*';
    }
    function primaryKey()
    {
        return 'id';
    }
    public function getUser($username)
    {
        $result = $this->db->table('user')->where('username', '=', $username)->firt();
        return $result;
    }
    public function getLastId($table)
    {
        $result = $this->db->table($table)->select('MAX(id) as id')->firt();
        return $result;
    }
    public function getProduct($id)
    {
        $result = $this->db->table('products')->where('id', '=', $id)->firt();
        return $result;
    }
    public function checkExist($table, $user_id, $product_id)
    {
        $result = $this->db->table($table)->where('user_id', '=', $user_id)->where('product_id', '=', $product_id)->firt();
        return $result;
    }
    public function  getInforCart($user_id, $product_id)
    {
        $img = $this->db->query("SELECT thumbnail FROM products WHERE id = $product_id ")->fetchColumn();

        if (strpos($img, './upload/') !== false) {
            $result['img']  = _WEB_ROOT . $img;
        } else {
            $result['img']  = $img;
        }
        $result['quantity'] = $this->db->query("SELECT * FROM cart_items WHERE user_id = $user_id ")->rowCount();
        $result['total_price'] = $this->db->query("SELECT SUM(total_price) as total FROM cart_items WHERE user_id = $user_id ")->fetchColumn();;
        return $result;
    }
    public function getItemOrder($id)
    {
        $result = $this->db->table('cart_items')->where('id', '=', $id)->select('product_id,quantity,total_price')->firt();
        return $result;
    }
    public function getName($id)
    {
        $result = $this->db->table('products')->where('id', '=', $id)->select('product_name')->firt();
        return $result;
    }
    public function getOne($table, $field, $value)
    {
        $result = $this->db->table($table)->where($field, '=', $value)->firt();
        return $result;
    }
    public function getCart($table, $user_id)
    {
        $result = $this->db->table($table)->where('user_id', '=', $user_id)->get();
        if (!empty($result)) {
            foreach ($result as $key => $item) {
                $imgList = $this->db->table('product_img')->where('product_id', '=', $item['product_id'])->firt();
                $price = $this->db->table('products')->where('id', '=', $item['product_id'])->select('price')->firt();
                $product = $this->db->table('products')->where('id', '=', $item['product_id'])->firt();
                $productname = $this->db->table('products')->where('id', '=', $item['product_id'])->select('product_name')->firt();
                $result[$key]['price'] = $price['price'];
                $result[$key]['product_name'] = $productname['product_name'];
                if (strpos($productname['product_name'], './upload/') == false) {
                    $result[$key]['imgDir'] = $product['thumbnail'];
                } else {
                    $result[$key]['imgDir'] = _WEB_ROOT . $product['thumbnail'];
                }
            }
        }
        return $result;
    }
    public function updateCart($table, $id, $data)
    {
        $result = $this->db->table($table)->where('id', '=', $id)->update($data);
        return $result;
    }
    public function insertCart($table, $data)
    {
        $result = $this->db->table($table)->insert($data);
        return $result;
    }
    public function removeCart($table, $id)
    {
        $result = $this->db->table($table)->where('id', '=', $id)->delete();
        return $result;
    }

    public function removeCartQuery($ids)
    {
        foreach ($ids as $id) {
            $result = $this->db->query('DELETE FROM cart_items WHERE id =  ' . $id);
        }
        return $result;
    }
    public function removeAll($table, $id)
    {
        $result = $this->db->table($table)->where('user_id', '=', $id)->delete();
        return $result;
    }
}
?>