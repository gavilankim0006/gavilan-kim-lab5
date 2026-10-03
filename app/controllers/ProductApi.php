<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

require_once APP_DIR . 'controllers/ApiController.php';

/**
 * Product CRUD endpoints. Every action requires a valid JWT.
 */
class ProductApi extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->api->require_jwt();
        $this->call->model('ProductModel');
    }

    /**
     * GET /api/products
     */
    public function index()
    {
        $products = $this->ProductModel->getAll();

        $this->api->respond([
            'data' => $products ?: [],
        ]);
    }

    /**
     * GET /api/products/{id}
     */
    public function show($id)
    {
        $product = $this->ProductModel->find($id);

        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->api->respond(['data' => $product]);
    }

    /**
     * POST /api/products
     */
    public function store()
    {
        $this->api->require_method('POST');

        $data = $this->validated($this->api->body());

        $id = $this->ProductModel->create($data);
        $product = $this->ProductModel->find($id);

        $this->api->respond([
            'message' => 'Product created.',
            'data'    => $product,
        ], 201);
    }

    /**
     * PUT/PATCH /api/products/{id}
     */
    public function update($id)
    {
        if (!in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'PATCH'], true)) {
            $this->api->respond_error('Method Not Allowed', 405);
        }

        $product = $this->ProductModel->find($id);
        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $data = $this->validated($this->api->body());
        $this->ProductModel->update($id, $data);

        $this->api->respond([
            'message' => 'Product updated.',
            'data'    => $this->ProductModel->find($id),
        ]);
    }

    /**
     * DELETE /api/products/{id}
     */
    public function destroy($id)
    {
        $this->api->require_method('DELETE');

        $product = $this->ProductModel->find($id);
        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->ProductModel->delete($id);

        $this->api->respond(['message' => 'Product deleted.']);
    }

    /**
     * Validate and normalise an incoming product payload.
     */
    private function validated($input)
    {
        $name     = trim($input['product_name'] ?? '');
        $price    = $input['price'] ?? null;
        $quantity = $input['quantity'] ?? null;

        $errors = [];

        if ($name === '' || mb_strlen($name) > 100) {
            $errors['product_name'] = 'Product name is required (max 100 characters).';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Price must be a number of 0 or greater.';
        }
        if (!is_numeric($quantity) || (int) $quantity < 0 || (string) (int) $quantity !== (string) $quantity) {
            $errors['quantity'] = 'Quantity must be a whole number of 0 or greater.';
        }

        if ($errors) {
            $this->api->respond(['error' => 'Validation failed.', 'errors' => $errors, 'status' => 422], 422);
        }

        return [
            'product_name' => $name,
            'description'  => trim($input['description'] ?? ''),
            'price'        => number_format((float) $price, 2, '.', ''),
            'quantity'     => (int) $quantity,
        ];
    }
}
