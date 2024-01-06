<?php
class Blog extends Controller
{
    public $blog_model, $data, $request, $response, $session;
    public function __construct()
    {
        $this->blog_model = $this->model('BlogModel');
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
    }
    function list()
    {
        if ($this->request->isGet()) {
            $limit = 10;
            $result = $this->request->getFields();
            if (!empty($result)) {
                $page = $result['page'];
                $offset = ($page - 1) * $limit;
            } else {
                $page = 1;
                $offset = 0;
            }
            $countRow = $this->blog_model->getCount('blogs');
            $maxPage = ceil($countRow / $limit);
            $list = $this->blog_model->getListLimit($limit, $offset);
        }
        $this->data['sub_content']['delete_error'] = $this->session->flash('delete_error');
        $this->data['sub_content']['delete_success'] = $this->session->flash('delete_success');;
        $this->data['sub_content']['page'] = $page;
        $this->data['sub_content']['maxPage'] = $maxPage;
        $this->data['sub_content']['list'] = $list;
        $this->data['content'] = 'admin/blog/list';
        $this->render('layout/admin_layout', $this->data);
    }
    function add()
    {
        $this->data['sub_content']['label_group'] = $this->blog_model->getListGroup();
        $this->data['sub_content']['error_upload'] = $this->session->flash('upload_file_erorr');
        $this->data['sub_content']['error'] = $this->session->flash('insert_error');
        $this->data['sub_content']['success'] = $this->session->flash('insert_success');
        $this->data['content'] = 'admin/blog/add';
        $this->render('layout/admin_layout', $this->data);
    }
    function handle_add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            $statusUpload = $this->blog_model->upload($_FILES);
            if ($statusUpload) {
                $this->request->rules([
                    'title' => 'required|min:4|max:255',
                    'meta' => 'required|min:4|max:255',
                    'content' => 'required|min:4',
                    'author' => 'required|min:4|max:50',
                ]);
                $this->request->messages([
                    'title.required' => 'Tiêu đề không được để trống',
                    'title.min' => 'Tiêu đề tối thiểu 4 kí tự',
                    'title.max' => 'Tiêu đề tối đa 255 kí tự',
                    'meta.required' => 'Thẻ meta không được để trống',
                    'meta.min' => 'Thẻ meta không được dưới 4 kí tự',
                    'meta.max' => 'Thẻ meta không được quá 255 kí tự',
                    'content.required' => 'Nội dung không được để trống',
                    'content.min' => 'Nội dung tối thiểu 4 kí tự',
                    'author.required' => 'Tác giả không được để trống',
                    'author.min' => 'Tác giả tối thiểu 4 kí tự',
                    'author.max' => 'Tác giả tối đa 50 kí tự',
                ]);
                $statusValides = $this->request->valides($data);
                if ($statusValides) {
                    $dirArr = $this->session->flash('dirArr');
                    $data['img'] = $dirArr['img'];

                    $statusInsert = $this->blog_model->insertBlog($data);
                    if ($statusInsert) {
                        $this->session->flash('insert_success', 'Thêm bài viết thành công!');
                        $this->response->redirect(_WEB_ROOT . '/admin/blog/add');
                    } else {
                        $this->session->flash('insert_error', 'Thêm sản phẩm thất bại!');
                        $this->response->redirect(_WEB_ROOT . '/admin/blog/add');
                    }
                } else {
                    $this->session->flash('insert_error', 'Lỗi kiểm tra dữ liệu');
                    $this->response->redirect(_WEB_ROOT . '/admin/blog/add');
                }
            } else {
                $this->session->flash('insert_error', 'Vui lòng chọn ảnh!');
                $this->response->redirect(_WEB_ROOT . '/admin/blog/add');
            }
        } else {
            $this->response->redirect(_WEB_ROOT . '/admin/blog/add');
        }
    }
    function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            $id = $data["id"];
            unset($data["id"]);
            $date = new DateTime();
            $data['update_at'] = $date->format('Y-m-d H:i:s');
            $this->request->rules([
                'product_name' => 'required|min:4|max:150',
                'made_in' => 'required|min:4|max:100',
                'form' => 'required|min:4|max:20',
                'author' => 'required|min:4|max:50',
                'description' => 'required|min:4|callback_check_word500',
                'short_description' => 'required|min:4|callback_check_word150',
                'specification' => 'required|min:4|callback_check_word150',
                'quantity' => 'required|number|positiveNumber',
                'price' => 'required|number|positiveNumber',
            ]);
            $this->request->messages([
                'product_name.required' => 'Tên sản phẩm không được để trống',
                'product_name.min' => 'Tên sản phẩm tối thiểu 4 kí tự',
                'product_name.max' => 'Tên sản phẩm tối đa 150 kí tự',
                'quantity.required' => 'Số lượng không được để trống',
                'quantity.number' => 'Số lượng phải là số',
                'quantity.positiveNumber' => 'Số phải dương',
                'price.required' => 'Giá không được để trống',
                'price.number' => 'Giá phải là số',
                'price.positiveNumber' => 'Giá phải dương',
                'made_in.required' => 'Nhà sản xuất không được để trống',
                'made_in.min' => 'Nhà sản xuất tối thiểu 4 kí tự',
                'made_in.max' => 'Nhà sản xuất tối đa 100 kí tự',
                'form.required' => 'Kiểu dáng không được để trống',
                'form.min' => 'Kiểu dáng tối thiểu 4 kí tự',
                'form.max' => 'Kiểu dáng tối đa 20 kí tự',
                'author.required' => 'Tác giả không được để trống',
                'author.min' => 'Tác giả tối thiểu 4 kí tự',
                'author.max' => 'Tác giả tối đa 50 kí tự',
                'description.required' => 'Mô tả xuất không được để trống',
                'description.min' => 'Mô tả xuất tối thiểu 4 kí tự',
                'description.callback_check_word500' => 'Mô tả xuất tối đa 500 từ',
                'short_description.required' => 'Mô tả ngắn xuất không được để trống',
                'short_description.min' => 'Mô tả ngắn xuất tối thiểu 4 kí tự',
                'short_description.callback_check_word150' => 'Mô tả ngắn xuất tối đa 150 từ',
                'specification.required' => 'Chi tiết xuất không được để trống',
                'specification.min' => 'Chi tiết xuất tối thiểu 4 kí tự',
                'specification.callback_check_word150' => 'Chi tiết xuất tối đa 150 từ',
            ]);
            $statusValides = $this->request->valides();
            if ($statusValides) {
                $statusInsert = $this->blog_model->updateProduct('products', $id, $data);
                if ($statusInsert) {
                    $this->session->flash('edit_success', 'Sửa sản phẩm thành công');
                    $this->response->redirect(_WEB_ROOT . '/admin/product/view?id=' . $id);
                }
            } else {
                $this->session->flash('edit_error', 'Lỗi kiểm tra dữ liệu');
                $this->response->redirect(_WEB_ROOT . '/admin/product/view?id=' . $id);
            }
        } else {
            $this->response->redirect(_WEB_ROOT . '/admin/product/');
        }
    }
    function edit_label()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            $id = $data['id'];
            unset($data['id']);
            if (isset($data['label']) && is_array($data['label'])) {
                $label = $data['label'];
                unset($data['label']);
                $this->blog_model->deleteTable('product_label', 'product_id', $id);
                foreach ($label as $item) {
                    $dataLabel['label_id'] = $item;
                    $dataLabel['product_id'] =  $id;
                    $statusInsert = $this->blog_model->insertLabel($dataLabel);
                }
                if ($statusInsert) {
                    $this->session->flash('edit_success', 'Sửa nhãn sản phẩm thành công');
                    $this->response->redirect(_WEB_ROOT . '/admin/product/view?id=' . $id);
                }
            } else {
                $this->session->flash('edit_error', 'Nhãn không được trống');
                $this->response->redirect(_WEB_ROOT . '/admin/product/view?id=' . $id); // Nếu mảng label không tồn tại hoặc không phải là mảng
            }
        }
    }
    function edit_img()
    {
        if ($this->request->isGet()) {
            $id = $this->request->getFields();
            $this->data['sub_content']['error'] = $this->session->flash('edit_error');
            $this->data['sub_content']['success'] = $this->session->flash('edit_success');
            $this->data['sub_content']['img_product'] = $this->blog_model->getOneImg($id['id']);
            $this->data['sub_content']['product_infor'] = $this->blog_model->getOne('products', $id['id']);
            $this->data['content'] = 'admin/products/edit_img';
            $this->render('layout/admin_layout', $this->data);
        }
    }
    function handle_edit_img()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            $id = $data['id'];
            unset($data['id']);
            $product_id = $data['product_id'];
            unset($data['product_id']);
            $statusUpload = $this->blog_model->upload($_FILES);
            $this->request->rules([
                'alt' => 'required|min:4|max:150',
                'link' => 'required|min:4|max:100',
            ]);
            $this->request->messages([
                'alt.required' => 'Alt không được để trống',
                'alt.min' => 'Alt tối thiểu 4 kí tự',
                'alt.max' => 'Alt tối đa 150 kí tự',
                'link.required' => 'Link không được để trống',
                'link.min' => 'Link tối thiểu 4 kí tự',
                'link.max' => 'Link tối đa 100 kí tự',
            ]);
            $statusValides = $this->request->valides();
            if ($statusUpload && $statusValides) {
                $dirImg = $this->session->flash('dirArr');
                $data['img_dir'] = $dirImg['img'];
                $statusUpdate = $this->blog_model->updateProduct('product_img', $id, $data);
                if ($statusUpdate) {
                    $this->session->flash('edit_success', 'Cập nhật sản phẩm thành công');
                    $this->response->redirect(_WEB_ROOT . '/admin/product/view?id=' . $product_id);
                }
            } else {
                $this->response->redirect(_WEB_ROOT . '/admin/product/edit_img?id=' . $id);
            }
        }
    }
    function view()
    {
        if ($this->request->isGet()) {
            $id = $this->request->getFields();
            $this->data['sub_content']['error'] = $this->session->flash('edit_error');
            $this->data['sub_content']['success'] = $this->session->flash('edit_success');
            $this->data['sub_content']['blog_infor'] = $this->blog_model->getOne('blogs', $id['id']);
            $this->data['content'] = 'admin/blog/view';
            $this->render('layout/admin_layout', $this->data);
        }
    }
    function delete()
    {
        if ($this->request->isGet()) {
            $id = $this->request->getFields();
            $deleteStatus = $this->blog_model->deleteBlog($id['id']);
            if ($deleteStatus) {
                $this->session->flash('delete_success', 'Xóa bài viết thành công');
                $this->response->redirect(_WEB_ROOT . '/admin/blog/list?page=1');
            } else {
                $this->session->flash('delete_error', 'Xóa bài viết thất bại');
                $this->response->redirect(_WEB_ROOT . '/admin/blog/list?page=1');
            }
        }
    }
    function warehouse()
    {
        $this->data['content'] = 'admin/products/warehouse';
        $this->render('layout/admin_layout', $this->data);
    }
    function statistical()
    {
        $this->data['content'] = 'admin/products/statistical';
        $this->render('layout/admin_layout', $this->data);
    }
    public function check_word500($string)
    {
        $countWord = str_word_count($string);
        if ($countWord < 500) {
            return false;
        } else {
            return true;
        }
    }
    public function check_word150($string)
    {
        $countWord = str_word_count($string);
        if ($countWord < 150) {
            return false;
        } else {
            return true;
        }
    }
}
