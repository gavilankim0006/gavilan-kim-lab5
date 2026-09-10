<?php
class Product extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Blocks ALL actions in this controller for unauthenticated users
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $this->call->model('ProductModel');
    }

    public function index()
    {
        $data['products'] = $this->ProductModel->getAll();
        $this->call->view('products/index', $data);
    }

    public function create()
    {
        $this->call->view('products/create');
    }

    public function store()
    {
        $data = [
            'product_name' => $_POST['product_name'],
            'description'  => $_POST['description'],
            'price'        => $_POST['price'],
            'quantity'     => $_POST['quantity'],
        ];
        $this->ProductModel->create($data);
        header('Location: /products');
        exit;
    }

    public function edit($id)
    {
        $data['product'] = $this->ProductModel->find($id);
        $this->call->view('products/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'product_name' => $_POST['product_name'],
            'description'  => $_POST['description'],
            'price'        => $_POST['price'],
            'quantity'     => $_POST['quantity'],
        ];
        $this->ProductModel->update($id, $data);
        header('Location: /products');
        exit;
    }

    public function delete($id)
    {
        $this->ProductModel->delete($id);
        header('Location: /products');
        exit;
    }
}