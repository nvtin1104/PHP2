<?php

use Pnlinh\VietnameseConverter\VietnameseConverter;

class BlogModel extends Model
{
    function tableFill()
    {
        return 'products';
    }
    function fieldFill()
    {
        return '*';
    }
    function primaryKey()
    {
        return 'id';
    }
    public function insertBlog($data)
    {
        $statusInsert = $this->db->table('blogs')->insert($data);
        return $statusInsert;
    }
    public function insertImgProduct($data)
    {
        $statusInsert = $this->db->table('product_img')->insert($data);
        return $statusInsert;
    }
    public function insertLabel($data)
    {
        $statusInsert = $this->db->query("INSERT INTO product_label (product_id, label_id) VALUES ('" . $data['product_id'] . "', '" . $data['label_id'] . "')");
        return $statusInsert;
    }
    public function getList($table)
    {
        $result = $this->db->table($table)->get();
        return $result;
    }
    public function getListLimit($limit, $offset = 0)
    {
        $result = $this->db->table('blogs')->limit($limit, $offset)->get();
        return $result;
    }
    public function getListLimitView($category, $limit, $offset = 0)
    {
        $result = $this->db->table('products')->where('category', '=', $category)->limit($limit, $offset)->get();
        foreach ($result as $key => $row) {
            $img = $this->db->select('img_dir')->table('product_img')->where('product_id', '=', $row['id'])->get();
            $result[$key]['img-0'] = substr($img[0]['img_dir'], 1);
            $result[$key]['img-1'] = substr($img[1]['img_dir'], 1);
        }
        return $result;
    }
    public function getDetail($id)
    {
        $result = $this->db->table('blogs')->where('id', '=', $id)->firt();
        return $result;
    }
    public function getDetailShow($id)
    {
        $result = $this->db->table('blogs')->where('id', '=', $id)->firt();
        $comment = $this->db->table('comment')->where('comment_to', '=', $id)->where('type', '=', 'blog')->get();
        $result['comment'] = $comment;
        return $result;
    }
    public function getOne($table, $id)
    {
        $result = $this->db->table($table)->where('id', '=', $id)->firt();
        return $result;
    }
    public function getLastId()
    {
        $result = $this->db->table('products')->select('MAX(id) as id')->firt();
        return $result;
    }
    public function getCount($field)
    {
        $result = $this->db->query("SELECT * FROM $field ")->rowCount();
        return $result;
    }

    public function deleteTable($table, $field, $value)
    {
        $result = $this->db->table($table)->where($field, '=', $value)->delete();
        return $result;
    }
    public function deleteBlog($id)
    {
        $result = $this->db->table('blogs')->where('id', '=', $id)->delete();
        return $result;
    }
    public function updateProduct($table, $id, $data)
    {
        $statusUpdate = $this->db->table($table)->where('id', '=', $id)->update($data);
        return $statusUpdate;
    }
    public function insertComment($data)
    {
        $statusInsert = $this->db->table('comment')->insert($data);
        return $statusInsert;
    }
    public function convertUrl($str)
    {
        $str = strtolower($str);
        $str = VietnameseConverter::make()
            ->convert($str);
        $str = str_replace(' ', '-', $str);
        $str = preg_replace('/[^a-z0-9\-]/', '', $str);
        $str = preg_replace('/-+/', '-', $str);

        return $str;
    }
    public function upload($files)
    {
        $session = new Session();
        $target_dir = './uploads/';
        // Thư mục lưu trữ tệp
        $dirArr = [];
        foreach ($files as $inputName => $file) {
            if (isset($file["error"]) && $file["error"] == UPLOAD_ERR_NO_FILE) {
                $session->data('upload_file_erorr', 'File ' . $inputName . ' trống');
            } elseif ($file["error"] == UPLOAD_ERR_OK) {
                // Tiếp tục xử lý tệp tin đã được tải lên
                $target_file = $target_dir . basename($file["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                // Kiểm tra định dạng hợp lệ và xử lý tiếp
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $session->flash('upload_file_erorr', 'Chỉ chấp nhận các tệp JPG, JPEG, PNG. Tại file ' . $inputName . '');
                } else {
                    if (file_exists($target_file)) {
                        $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
                        $newFileName = $fileName . '-Copy';
                        $target_file = $target_dir . $newFileName . '.' . $imageFileType;
                        $cnt = 1;
                        while (file_exists($target_file)) {
                            $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
                            $newFileName = $fileName . '-Copy(' . $cnt . ')';
                            $target_file = $target_dir . $newFileName . '.' . $imageFileType;
                            $cnt++;
                        }
                    }
                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        // Lưu thông tin sản phẩm vào cơ sở dữ liệu
                        $dirArr[$inputName] = $target_file;
                    } else {
                        $session->flash('upload_file_erorr', 'Lỗi khi tải file ' . $inputName . '');
                    }
                }
            }
        }
        $error = $session->flash('upload_file_erorr');
        if (!empty($error)) {
            return false;
        } else {
            $session->flash('dirArr', $dirArr);
            return  true;
        }
    }
}
