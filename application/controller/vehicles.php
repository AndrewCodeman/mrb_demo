<?php

/**
 * Class Vehicles
 *
 *
 */
class Vehicles extends Controller
{
    

    function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }
    public function loadModel()
    {
        require_once APP . 'model/vehiclemodel.php';
        // create new "model" (and pass the database connection)
        $this->model = new VehicleModel($this->db);
    }
    /**
     * PAGE: index
     */
    public function index()
    {
        // getting all vehicles and amount of vehicles
        $vehicles = $this->model->getAllVehicles();
        $amount_of_vehicles = $this->model->getAmountOfVehicles();
        $customers = $this->model->getAllCustomers();
       // load views. within the views we can echo out $vehicles and $amount_of_vehicles easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/vehicles/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function customer($customer_id)
    {
        // getting all orders and amount of orders
        $customername=$this->model->getCustomerName($customer_id);
        $vehicles = $this->model->getVehiclesCustomer($customer_id);
        $amount_of_vehicles = $this->model->getAmountOfVehiclesCustomer($customer_id);
        // load views. within the views we can echo out $orders and $amount_of_orders easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/vehicles/customer.php';
        require APP . 'view/_templates/footer.php';
    }
    /**
     * ACTION: addVehicle
     * This method handles what happens when you move to http://yourproject/vehicles/addvehicle
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a vehicle" form on vehicles/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to vehicles/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addVehicle()
    {
        // if we have POST data to create a new vehicle entry
        if (isset($_POST["submit_add_vehicle"])) {
            // do addVehicle() in model/model.php
            $this->model->addVehicle($_POST["plate"], $_POST["customer"], $_POST["type"]);
        }

        // where to go after vehicle has been added
        header('location: ' . URL . 'vehicles/index');
    }

    /**
     * ACTION: deleteVehicle
     * This method handles what happens when you move to http://yourproject/vehicles/deletevehicle
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a vehicle" button on vehicles/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to vehicles/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $vehicle_id Id of the to-delete vehicle
     */
    public function deleteVehicle($vehicle_id)
    {
        // if we have an id of a vehicle that should be deleted
        if (isset($vehicle_id)) {
            // do deleteVehicle() in model/model.php
            $this->model->deleteVehicle($vehicle_id);
        }

        // where to go after vehicle has been deleted
        header('location: ' . URL . 'vehicles/index');
    }

     /**
     * ACTION: editVehicle
     * This method handles what happens when you move to http://yourproject/vehicles/editvehicle
     * @param int $vehicle_id Id of the to-edit vehicle
     */
    public function editVehicle($vehicle_id)
    {
        // if we have an id of a vehicle that should be edited
        if (isset($vehicle_id)) {
            // do getVehicle() in model/model.php
            $vehicle = $this->model->getVehicle($vehicle_id);
            $customers = $this->model->getAllCustomers();
            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $vehicle easily
            require APP . 'view/_templates/header.php';
            require APP . 'view/vehicles/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            // redirect user to vehicles index page (as we don't have a vehicle_id)
            header('location: ' . URL . 'vehicles/index');
        }
    }
    
    /**
     * ACTION: updateVehicle
     * This method handles what happens when you move to http://yourproject/vehicles/updatevehicle
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a vehicle" form on vehicles/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to vehicles/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateVehicle()
    {
        // if we have POST data to create a new vehicle entry
        if (isset($_POST["submit_update_vehicle"])) {
            // do updateVehicle() from model/model.php
            $this->model->updateVehicle($_POST["plate"], $_POST["customer"],  $_POST["type"], $_POST['vehicle_id']);
        }

        // where to go after vehicle has been added
        header('location: ' . URL . 'vehicles/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_vehicles = $this->model->getAmountOfVehicles();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_vehicles;
    }

}
