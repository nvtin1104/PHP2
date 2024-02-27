<?php
class Cart extends Controller
{
    public $cart_model, $data, $request, $response, $session, $home;
    public function __construct()
    {
        $this->cart_model = $this->model('CartModel');
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->home = _WEB_ROOT . '/home';
    }
    function cart()
    {
        if ($this->request->isGet()) {
            if ($this->session->data('isLogin')) {
                $currentUser = $this->session->data('user_name');
                $dataUser = $this->cart_model->getUser($currentUser);
                $cartData = $this->cart_model->getCart('cart_items', $dataUser['id']);
            } else {
                $cartData = '';
            }
            $this->data['sub_content']['error'] =  $this->session->flash('error_remove_cart');
            $this->data['sub_content']['success'] =  $this->session->flash('success_remove_cart');
            $this->data['sub_content']['cart'] =  $cartData;
            $this->data['page_title'] = 'Giỏ hàng';
            $this->data['content'] = 'cart/index';
            $this->render('layout/client_layout', $this->data);
        }
    }
    function wishlist()
    {
        if ($this->session->data('isLogin')) {
            $currentUser = $this->session->data('user_name');
            $dataUser = $this->cart_model->getUser($currentUser);
            $cartData = $this->cart_model->getCart('wishlist', $dataUser['id']);
        } else {
            $cartData = '';
        }
        $this->data['sub_content']['wishlist'] =  $cartData;
        $this->data['page_title'] = 'Danh sách yêu thích';
        $this->data['content'] = 'cart/wishlist';
        $this->render('layout/client_layout', $this->data);
    }
    function checkout()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            if (!empty($data)) {
                foreach ($data['ids'] as $key) {
                    $cartItems = $this->cart_model->getOne('cart_items', 'id', $key);
                    $cartItem = $this->cart_model->getName($cartItems['product_id']);
                    $cartItems['product_name'] = $cartItem['product_name'];
                    $cart[] = $cartItems;
                }
                $sumTotal = 0;
                foreach ($cart as $item) {
                    $sumTotal += $item['total_price'];
                }
                if ($sumTotal != 0) {
                    $this->data['sub_content']['cart'] =  $cart;
                    $this->data['sub_content']['total_price'] =  $sumTotal;
                    $this->data['page_title'] = 'Thanh toán';
                    $this->data['content'] = 'cart/checkout';
                    $this->render('layout/client_layout', $this->data);
                } else {
                    $this->session->data('error_remove_cart',  'Sản phẩm không tồn tại.');
                    $this->response->redirect(_WEB_ROOT . '/cart/cart');
                }
            } else {
                $this->session->data('error_remove_cart',  'Chưa chọn sản phẩm.');
                $this->response->redirect(_WEB_ROOT . '/cart/cart');
            }
        } else {
            $this->response->redirect(_WEB_ROOT . '/cart/cart');
        }
    }
    function handleAddToCart()
    {
        if ($this->request->isPost()) {
            $responsiveJson = [];
            $isLogin = $this->session->data('isLogin');
            $currentUser = $this->session->data('user_name');
            $formData = $this->request->getFields();
            $productData = $this->cart_model->getProduct($formData['product_id']);
            $price = $productData['price'];
            if ($isLogin) {
                $dataUser = $this->cart_model->getUser($currentUser);
                $id = $dataUser['id'];
                if (intval($formData['quantity']) > 0) {
                    $checkExist = $this->cart_model->checkExist('cart_items', $id, $formData['product_id']);
                    if ($checkExist) {
                        $cartQuantity = $checkExist['quantity'];
                        $newQuantity = $cartQuantity + $formData['quantity'];
                        $newPrice = $newQuantity * $price;
                        $dataUpdate = [];
                        $dataUpdate['total_price'] = $newPrice;
                        $dataUpdate['quantity'] = $newQuantity;
                        $statusUpdate = $this->cart_model->updateCart('cart_items', $checkExist['id'], $dataUpdate);
                        $inforCart = $this->cart_model->getInforCart($id, $formData['product_id']);
                        $responsiveJson["infor"] = $inforCart;
                        if ($statusUpdate) {
                            $responsiveJson["success"] = 'Thêm vào giỏ hàng thành công.';
                        } else $responsiveJson["error"] = 'Thêm vào giỏ hàng thất bại';
                    } else {
                        $formData['total_price'] = $formData['quantity'] * $price;
                        $formData['user_id'] = $id;
                        $statusInsert = $this->cart_model->insertCart('cart_items', $formData);
                        if ($statusInsert) {
                            $inforCart = $this->cart_model->getInforCart($id, $formData['product_id']);
                            $responsiveJson["infor"] = $inforCart;
                            $responsiveJson["success"] = 'Thêm vào giỏ hàng thành công.';
                        } else $responsiveJson["error"] = 'Thêm vào giỏ hàng thất bại';
                    }
                } else {
                    $responsiveJson["error"] = 'Vui lòng chọn đúng số lượng!';
                }
            } else {
                $responsiveJson["error"] = 'Chưa đăng nhập';
            }
            echo json_encode($responsiveJson);
        } else {
            $this->response->redirect($this->home);
        }
    }
    function handleUpdateCart()
    {
        if ($this->request->isPost()) {
            $responsiveJson = [];
            $formData = $this->request->getFields();
            $id = $formData['id'];
            unset($formData['id']);
            $product_id = $formData['product_id'];
            unset($formData['product_id']);
            $dataCart =  $this->cart_model->getOne('products', 'id', $product_id);
            $price = $dataCart['price'];
            $formData['total_price'] = $price * $formData['quantity'];
            $responsiveJson["success"] = $formData['total_price'];
            if (intval($formData['quantity']) > 0) {
                $statusUpdate = $this->cart_model->updateCart('cart_items', $id, $formData);
                if ($statusUpdate) {
                    $responsiveJson["success"] = 'Cập nhật giỏ hàng thành công';
                } else {
                    $responsiveJson["error"] = 'Cập nhật giỏ hàng thất bại';
                }
            } else {
                $responsiveJson["error"] = 'Vui lòng chọn đúng số lượng!';
            }

            echo json_encode($responsiveJson);
        } else {
            $this->response->redirect($this->home);
        }
    }
    function handleAddToWishlist()
    {
        if ($this->request->isPost()) {
            $responsiveJson = [];
            $isLogin = $this->session->data('isLogin');
            $currentUser = $this->session->data('user_name');
            $formData = $this->request->getFields();
            $productData = $this->cart_model->getProduct($formData['product_id']);
            $price = $productData['price'];
            if ($isLogin) {
                $dataUser = $this->cart_model->getUser($currentUser);
                $id = $dataUser['id'];
                $checkExist = $this->cart_model->checkExist('wishlist', $id, $formData['product_id']);
                if ($checkExist) {
                    $responsiveJson["infor"] = 'Sản phẩm đã có trong danh sách yêu thích.';
                } else {
                    $formData['total_price'] = $formData['quantity'] * $price;
                    $formData['user_id'] = $id;
                    $statusInsert = $this->cart_model->insertCart('wishlist', $formData);
                    if ($statusInsert) {
                        $inforCart = $this->cart_model->getInforCart($id, $formData['product_id']);
                        $responsiveJson["infor"] = $inforCart;
                        $responsiveJson["success"] = 'Thêm vào danh sách yêu thích thành công.';
                    } else $responsiveJson["error"] = 'Thêm vào danh sách yêu thích thất bại';
                }
            } else {
                $responsiveJson["error"] = 'Chưa đăng nhập';
            }
            echo json_encode($responsiveJson);
        } else {
            $this->response->redirect($this->home);
        }
    }
    function handleRemoveCart()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getFields();
            $id = $id['id'];
            $statusRemove = $this->cart_model->removeCart('cart_items', $id);
            if ($statusRemove) {
                $responsiveJson["success"] = 'Xóa sản phẩm thành công.';
            } else {
                $responsiveJson["error"] = 'Xóa sản phẩm thất bại';
            }
            echo json_encode($responsiveJson);
        } else {
            $this->response->redirect($this->home);
        }
    }
    function handleRemoveArr()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            if (!empty($data)) {
                $data = $data['ids'];
                $statusRemove = $this->cart_model->removeCartQuery($data);
                if ($statusRemove) {
                    $this->session->data('success_remove_cart',  'Xóa sản phẩm thành công.');
                    $this->response->redirect(_WEB_ROOT . '/cart/cart');
                } else {
                    $this->session->data('error_remove_cart',  'Xóa sản phẩm thất bại.');
                    $this->response->redirect(_WEB_ROOT . '/cart/cart');
                }
            } else {
                $this->session->data('error_remove_cart', 'Chưa chọn sản phẩm!');
                $this->response->redirect(_WEB_ROOT . '/cart/cart');
            }
        } else {
            $this->response->redirect(_WEB_ROOT . '/cart/cart');
        }
    }
    function handleRemoveAll()
    {
        if ($this->request->isPost()) {
            $isLogin = $this->session->data('isLogin');
            $currentUser = $this->session->data('user_name');
            if ($isLogin) {
                $dataUser = $this->cart_model->getUser($currentUser);
                $id = $dataUser['id'];

                $statusRemove = $this->cart_model->removeAll('cart_items', $id);
                if ($statusRemove) {
                    $this->response->redirect(_WEB_ROOT . '/cart/cart');
                } else {
                    $this->session->data('error_remove_cart',  'Xóa sản phẩm thất bại.');
                    $this->response->redirect(_WEB_ROOT . '/cart/cart');
                }
            } else {
                $this->response->redirect(_WEB_ROOT . '/cart/cart');
            }
        } else {
            $this->response->redirect(_WEB_ROOT . '/cart/cart');
        }
    }
    function handleRemoveWishlist()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getFields();
            $id = $id['id'];
            $statusRemove = $this->cart_model->removeCart('wishlist', $id);
            if ($statusRemove) {
                $responsiveJson["success"] = 'Xóa sản phẩm thành công.';
            } else {
                $responsiveJson["error"] = 'Xóa sản phẩm thất bại';
            }
            echo json_encode($responsiveJson);
        } else {
            $this->response->redirect($this->home);
        }
    }
    function handleCfShip()
    {
        if ($this->request->isGet()) {
            $data = $this->request->getFields();
            $data['status'] = 3;
            $statusUpdate = $this->cart_model->updateCart('orders', $data['id'], $data);
            if ($statusUpdate) {
                $this->session->data('cf_order', 'Cập nhật thành công');
                $this->response->redirect(_WEB_ROOT . '//profile/view_order?id=' . $data['id']);
            }
        }
    }
    function handleCancelOrder()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            $dataUpdate['status'] = 0;
            if ($data) {
                $this->request->rules(
                    ['reason' => 'required|min:10']
                );
                $this->request->messages([
                    'reason.required' => 'Lí do hủy không được để trống',
                    'reason.min' => 'Lí do hủy tối thiểu 10 kí tự',
                ]);
                $this->request->valides();
                if ($this->request->valides()) {
                    $cancelStatus = $this->cart_model->updateCart('orders', $data['order_id'], $dataUpdate);
                    if ($cancelStatus) {
                        $this->cart_model->insertCart('orders_cancel', $data);
                        $responsiveJson["success"] = 'Cập nhật thành công';
                    }
                } else {
                    $sessionKey = Session::isInvalid();
                    $errors = Session::flash($sessionKey . '_errors');
                    $error = reset($errors);
                    $responsiveJson["error"] = $error;
                }
                echo json_encode($responsiveJson);
            }
        }
    }
    function handleCheckout()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getFields();
            $cart_id = $data['cart_id'];
            unset($data['cart_id']);
            $this->request->rules([
                'phone' => 'required|phone|max:10',
                'fullname' => 'required|min:4|max:100',
                'address' => 'required|min:10|max:150',
                'email' => 'required|min:4|max:100|email',
                'note' => 'max:500',
            ]);
            $this->request->messages([
                'fullname.required' => 'Họ và tên không được để trống',
                'fullname.min' => 'Họ và tên tối thiểu 4 kí tự',
                'fullname.max' => 'Họ và tên tối đa 100 kí tự',
                'phone.required' => 'SDT không được để trống',
                'phone.phone' => 'SDT không đúng định dạng',
                'phone.max' => 'SDT không đúng định dạng',
                'address.required' => 'Địa chỉ không được để trống',
                'address.min' => 'Địa chỉ tối thiểu 10 kí tự',
                'address.max' => 'Địa chỉ tối đa 150 kí tự',
                'email.required' => 'Mail không được để trống',
                'email.min' => 'Mail tối thiểu 4 kí tự',
                'email.max' => 'Mail tối đa 100 kí tự',
                'email.email' => 'Mail không đúng định dạng',
                'note.max' => 'Ghi chú tối đa 500 kí tự',
            ]);
            $statusValidate = $this->request->valides();
            if ($statusValidate) {
                $currentDate = date("Y-m-d H:i:s");
                $currentDate = str_replace("-", "",  str_replace(":", "",  str_replace(" ", "", $currentDate)));
                $data['order_code'] = '#OD' . $currentDate;
                $statusInsert = $this->cart_model->insertCart('orders', $data);
                if ($statusInsert) {
                    $orderStatusCheck = true;
                    $order_id = $this->cart_model->getLastId('orders');
                    foreach ($cart_id as $item) {
                        $statusGet = $this->cart_model->getItemOrder($item);
                        $product_infor = $this->cart_model->getProduct($statusGet['product_id']);

                        if ($statusGet) {
                            $orderList = $statusGet;
                            $orderList['order_id'] = $order_id['id'];
                            $statusOrder = $this->cart_model->insertCart('order_list', $orderList);
                            if (intval($statusGet['quantity']) > intval($product_infor['quantity'])) {
                                $orderStatusCheck = false;
                            }
                        }
                    }
                    if ($statusOrder && $orderStatusCheck) {
                        $statusRemove = $this->cart_model->removeCartQuery($cart_id);
                        if ($statusRemove) {
                            $responsiveJson['success'] = 'Đặt hàng thành công!';
                            if ($data['payment'] == 2) {
                                $responsiveJson['data'] = [
                                    'order_id' => $order_id['id'],
                                    'total_price' => $data['total_price'],
                                    'order_code' => $data['order_code']
                                ];
                            }
                        } else {
                            $responsiveJson['error'] = 'Đặt hàng thất bại!';
                        }
                    } else {
                        $responsiveJson['error'] = 'Đặt hàng thất bại! Quá số lượng tồn hàng!';
                    }
                }
            } else {
                $sessionKey = Session::isInvalid();
                $error =   Session::flash($sessionKey . '_errors');
                $responsiveJson['error'] = reset($error);
            }
            echo json_encode($responsiveJson);
        }
    }
    function handlePaymentReturn()
    {
        // require_once("./config.php");
        $inputData = array();
        $returnData = array();

        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $vnp_HashSecret = $_ENV['vnp_HashSecret'];
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   
                $order = $this->cart_model->getOne('orders', 'id', $orderId);
                if ($order != NULL) {
                    if ($order["total_price"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        if ($order["status"] == 1) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $data = $this->request->getFields();
                                $baseUrl = _WEB_ROOT . '/cart/handlePaymentReturn';
                                // Tạo query string từ mảng dữ liệu
                                $queryString = http_build_query($data);

                                // Tạo URL hoàn chỉnh
                                $completeUrl = $baseUrl . '?' . $queryString;
                                $dataUpdate = [
                                    'status' => 1,
                                    'payment_return' => $completeUrl
                                ];
                                $orderUpdate['status'] = 5;
                                $dataPayment = $this->cart_model->getOne('handle_payment', 'order_id', $orderId);
                                $status = $this->cart_model->updateCart('orders', $orderId, $orderUpdate);
                                if ($status) {
                                    $update = $this->cart_model->updateCart('handle_payment', $dataPayment['id'], $dataUpdate);
                                    $returnData['message'] = 'Xác nhận thành công';
                                    $returnData['status'] = 'Success';
                                } else {
                                    $returnData['message'] = 'Xác nhận thất bại';
                                    $returnData['status'] = 'Fail';
                                }
                            } else {
                                $returnData['message'] = 'Thanh toán thất bại';
                                $returnData['status'] = 'Fail';
                            }
                        } else {
                            $returnData['message'] = 'Đơn hàng đã được xử lý';
                            $returnData['status'] = 'Warning';
                        }
                    } else {
                        $returnData['status'] = 'Fail';
                        $returnData['message'] = 'Số tiền không hợp lệ';
                    }
                } else {
                    $returnData['status'] = 'Fail';
                    $returnData['message'] = 'Không tìm thấy đơn hàng';
                }
            } else {
                $returnData['status'] = 'Fail';
                $returnData['message'] = 'Chữ ký không hợp lệ';
            }
        } catch (Exception $e) {
            $returnData['status'] = 'Fail';
            $returnData['message'] = 'Không tồn tại';
        }
        //Trả lại VNPAY theo định dạng JSON
        $this->data['sub_content']['data'] =  $returnData;
        $this->data['page_title'] = 'Thanh toán';
        $this->data['content'] = 'cart/mess';
        $this->render('layout/client_layout', $this->data);
    }
    function handlePayment()
    {
        $data = $this->request->getFields();
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/php2/cart/handlePaymentReturn";
        $vnp_TmnCode = $_ENV['vnp_TmnCode'];
        $vnp_HashSecret = $_ENV['vnp_HashSecret'];

        $vnp_TxnRef = $data['order_id'];
        // $vnp_TxnRef = $_POST['order_id']; 
        // $vnp_OrderInfo = $_POST['order_desc'];
        // $vnp_OrderType = $_POST['order_type'];
        // $vnp_Amount = $_POST['amount'];
        $vnp_Amount = $data['total'] * 100;
        $vnp_OrderInfo = $data['order_code'];
        $vnp_OrderType = 'billpayment';

        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        // //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address = $_POST['txt_inv_addr1'];
        // $vnp_Bill_City = $_POST['txt_bill_city'];
        // $vnp_Bill_Country = $_POST['txt_bill_country'];
        // $vnp_Bill_State = $_POST['txt_bill_state'];
        // Invoice
        // $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
        // $vnp_Inv_Email = $_POST['txt_inv_email'];
        // $vnp_Inv_Customer = $_POST['txt_inv_customer'];
        // $vnp_Inv_Address = $_POST['txt_inv_addr1'];
        // $vnp_Inv_Company = $_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type = $_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            // "vnp_ExpireDate" => $vnp_ExpireDate,
            // "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            // "vnp_Bill_Email" => $vnp_Bill_Email,
            // "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            // "vnp_Bill_LastName" => $vnp_Bill_LastName,
            // "vnp_Bill_Address" => $vnp_Bill_Address,
            // "vnp_Bill_City" => $vnp_Bill_City,
            // "vnp_Bill_Country" => $vnp_Bill_Country,
            // "vnp_Inv_Phone" => $vnp_Inv_Phone,
            // "vnp_Inv_Email" => $vnp_Inv_Email,
            // "vnp_Inv_Customer" => $vnp_Inv_Customer,
            // "vnp_Inv_Address" => $vnp_Inv_Address,
            // "vnp_Inv_Company" => $vnp_Inv_Company,
            // "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            // "vnp_Inv_Type" => $vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        $dataInsert  = [
            'order_id' => $data['order_id'],
            'payment_url' => _WEB_ROOT . '/cart/handlePayment?order_id=' . $data['order_id'] . '&total=' . $data['total'] . '&order_code=' . $data['order_code'],
        ];
        $statusInsert = $this->cart_model->insertCart('handle_payment', $dataInsert);
        if ($statusInsert) {
            if (isset($_POST['redirect'])) {
                // echo json_encode($vnp_Url);
                header("Location: " . $vnp_Url);
                die();
            } else {
                header("Location: " . $vnp_Url);
            }
        }
    }
}
?>