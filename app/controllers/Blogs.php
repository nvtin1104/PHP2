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
    public function detail()
    {
        if ($this->request->isGet()) {
            $id = $this->request->getFields();
            $data = $this->blog_model->getDetail($id['id']);
        }
        $this->data['sub_content']['blog'] = $data;
        $this->data['content'] = 'blogs/detail';
        $this->render('layout/client_layout', $this->data);
    }
}
