<?php


class Blogs extends Controller
{
    public $blog_model, $data, $request, $response, $session;
    public function __construct()
    {
        $this->blog_model = $this->model('BlogModel');
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
    }
    public function index()
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
        $this->data['content'] = 'blogs/list';
        $this->render('layout/client_layout', $this->data);
    }
    public function handleCreateComment()
    {
        if ($this->request->isPost()) {
            $responsiveJson = [];
            $formData = $this->request->getFields();
            $this->request->rules([
                'email' => 'required|min:4|max:100|email',
                'content' => 'required|min:4',
                'name' => 'required|min:4|max:45',
            ]);
            $this->request->messages([

                'email.required' => ' Email không được để trống',
                'email.min' => ' Email không được dưới 4 kí tự',
                'email.max' => ' Email không được quá 100 kí tự',
                'email.email' => 'Email không đúng định dạng',
                'content.required' => 'Nội dung không được để trống',
                'content.min' => 'Nội dung tối thiểu 4 kí tự',
                'name.required' => 'Tên không được để trống',
                'name.min' => 'Tên tối thiểu 4 kí tự',
                'name.max' => 'Tên tối đa 45 kí tự',
            ]);
            $statusValides = $this->request->valides($formData);
            if ($statusValides) {
                $statusInsert = $this->blog_model->insertComment($formData);
                if ($statusInsert) {
                    $responsiveJson["success"] = 'Bình luận thành công';
                } else {
                    $responsiveJson["error"] = 'Thêm thất bại';
                }
            } else {
                $errors = $this->request->errors();
                $responsiveJson["error"] = reset($errors);
            }
        } else {
            $responsiveJson["error"] = 'Chưa đăng nhập';
        }
        echo json_encode($responsiveJson);
    }
    public function detail()
    {
        if ($this->request->isGet()) {
            $url = $this->request->getFields();
            $data = $this->blog_model->getDetailShow($url['id']);
        }
        $this->data['sub_content']['blog'] = $data;
        $this->data['meta'] = $data['meta'];
        $this->data['content'] = 'blogs/detail';
        $this->render('layout/client_layout', $this->data);
    }
}
