<?php
class PaymentController
{
    private $model;

    public function __construct()
    {
        $this->model = new PaymentModel;
    }

    public function index()
    {
        $submissions = $this->model->getAll();
        include('../views/submission_list.php');
    }

    public function create()
    {
        include('../views/submission_form.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $buyer = $_POST['buyer'];
            $receipt_id = $_POST['receipt_id'];
            $items = $_POST['items'];
            $buyer_email = $_POST['buyer_email'];
            $buyer_ip = $_POST['buyer_ip'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $hash_key = $_POST['receipt_id'];
            $entry_at = date("Y-m-d");
            $entry_by = $_POST['name'];

            $errors = [];

            if (empty($amount) || empty($buyer_email)) {
                $errors[] = 'Name and Email are required fields.';
            }

            if (!filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }

            if (empty($errors)) {
                $this->model->insert($amount, $buyer, $receipt_id, $items, $buyer_email, $buyer_ip, $city, $phone, $hash_key, $entry_at, $entry_by);
            } else {
                // Handle errors
                // You can pass the errors to the view or redirect to the form with error messages
            }
        }
        // Redirect to the submission list
        header('Location: /list');
    }
}
