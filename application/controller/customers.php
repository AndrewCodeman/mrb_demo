<?php

/**
 * Class Customers
 *
 *
 */
class Customers extends Controller
{
    

    function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }
    public function loadModel()
    {
        require_once APP . 'model/customermodel.php';
        // create new "model" (and pass the database connection)
        $this->model = new CustomerModel($this->db);
    }
    /**
     * PAGE: index
     */
    public function index()
    {
        // getting all customers and amount of customers
        $customers = $this->model->getAllCustomers();
        $amount_of_customers = $this->model->getAmountOfCustomers();

       // load views. within the views we can echo out $customers and $amount_of_customers easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/customers/index.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * ACTION: addCustomer
     * This method handles what happens when you move to http://yourproject/customers/addcustomer
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a customer" form on customers/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to customers/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addCustomer()
    {
        // if we have POST data to create a new customer entry
        if (isset($_POST["submit_add_customer"])) {
            // do addCustomer() in model/model.php
            $this->model->addCustomer($_POST["name"], $_POST["address"],  $_POST["email"], $_POST["phone"], $_POST["respondMethod"]);
        }

        // where to go after customer has been added
        header('location: ' . URL . 'customers/index');
    }

    /**
     * ACTION: deleteCustomer
     * This method handles what happens when you move to http://yourproject/customers/deletecustomer
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a customer" button on customers/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to customers/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $customer_id Id of the to-delete customer
     */
    public function deleteCustomer($customer_id)
    {
        // if we have an id of a customer that should be deleted
        if (isset($customer_id)) {
            // do deleteCustomer() in model/model.php
            $this->model->deleteCustomer($customer_id);
        }

        // where to go after customer has been deleted
        header('location: ' . URL . 'customers/index');
    }

     /**
     * ACTION: editCustomer
     * This method handles what happens when you move to http://yourproject/customers/editcustomer
     * @param int $customer_id Id of the to-edit customer
     */
    public function editCustomer($customer_id)
    {
        // if we have an id of a customer that should be edited
        if (isset($customer_id)) {
            // do getCustomer() in model/model.php
            $customer = $this->model->getCustomer($customer_id);

            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $customer easily
            require APP . 'view/_templates/header.php';
            require APP . 'view/customers/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            // redirect user to customers index page (as we don't have a customer_id)
            header('location: ' . URL . 'customers/index');
        }
    }
    
    /**
     * ACTION: updateCustomer
     * This method handles what happens when you move to http://yourproject/customers/updatecustomer
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a customer" form on customers/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to customers/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateCustomer()
    {
        // if we have POST data to create a new customer entry
        if (isset($_POST["submit_update_customer"])) {
            // do updateCustomer() from model/model.php
            $this->model->updateCustomer($_POST["name"], $_POST["address"],  $_POST["email"], $_POST["phone"], $_POST["respondMethod"], $_POST['customer_id']);
        }

        // where to go after customer has been added
        header('location: ' . URL . 'customers/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_customers = $this->model->getAmountOfCustomers();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_customers;
    }

}
