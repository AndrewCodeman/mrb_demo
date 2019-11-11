<?php

/**
 * Class Orders
 *
 *
 */
class Orders extends Controller
{
    

    function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }
    public function loadModel()
    {
        require_once APP . 'model/ordermodel.php';
        // create new "model" (and pass the database connection)
        $this->model = new OrderModel($this->db);
    }
    /**
     * PAGE: index
     */
    public function index()
    {
        // getting all orders and amount of orders
        $orders = $this->model->getAllOrders();
        $amount_of_orders = $this->model->getAmountOfOrders();
       // load views. within the views we can echo out $orders and $amount_of_orders easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/orders/index.php';
        require APP . 'view/_templates/footer.php';
    }
    public function customer($customer_id)
    {
        // getting all orders and amount of orders
        $customername=$this->model->getCustomerName($customer_id);
        $orders = $this->model->getOrdersCustomer($customer_id);
        $amount_of_orders = $this->model->getAmountOfOrdersCustomer($customer_id);
        // load views. within the views we can echo out $orders and $amount_of_orders easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/orders/customer.php';
        require APP . 'view/_templates/footer.php';
    }
    /**
     * ACTION: addOrder
     * This method handles what happens when you move to http://yourproject/orders/addorder
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a order" form on orders/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to orders/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addOrder()
    {
        // if we have POST data to create a new order entry
        if (isset($_POST["submit_add_order"])) {
            // do addOrder() in model/model.php
            $this->model->addOrder($_POST["vehicleId"], $_POST["customerId"]);
        }

        // where to go after order has been added
        header('location: ' . URL . 'orders/index');
    }

    /**
     * ACTION: deleteOrder
     * This method handles what happens when you move to http://yourproject/orders/deleteorder
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a order" button on orders/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to orders/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $order_id Id of the to-delete order
     */
    public function deleteOrder($order_id)
    {
        // if we have an id of a order that should be deleted
        if (isset($order_id)) {
            // do deleteOrder() in model/model.php
            $this->model->deleteOrder($order_id);
        }

        // where to go after order has been deleted
        header('location: ' . URL . 'orders/index');
    }

     /**
     * ACTION: editOrder
     * This method handles what happens when you move to http://yourproject/orders/editorder
     * @param int $order_id Id of the to-edit order
     */
    public function editOrder($order_id)
    {
        // if we have an id of a order that should be edited
        if (isset($order_id)) {
            // do getOrder() in model/model.php
            $order = $this->model->getOrder($order_id);
            $vehicles = $this->model->getVehicles($order->customerId);
            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $order easily
            require APP . 'view/_templates/header.php';
            require APP . 'view/orders/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            // redirect user to orders index page (as we don't have a order_id)
            header('location: ' . URL . 'orders/index');
        }
    }

    public function getVehicles($customerId)
    {
        echo json_encode($this->model->getVehicles($customerId));
    }
    /**
     * ACTION: updateOrder
     * This method handles what happens when you move to http://yourproject/orders/updateorder
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a order" form on orders/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to orders/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateOrder()
    {
        // if we have POST data to create a new order entry
        if (isset($_POST["submit_update_order"])) {
            // do updateOrder() from model/model.php
            $this->model->updateOrder($_POST["vehicleId"], $_POST["customerId"],  $_POST["created"], $_POST["complected"], $_POST['order_id']);
        }

        // where to go after order has been added
        header('location: ' . URL . 'orders/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_orders = $this->model->getAmountOfOrders();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_orders;
    }

}
