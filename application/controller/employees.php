<?php

/**
 * Class Employees
 *
 *
 */
class Employees extends Controller
{
    

    function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }
    public function loadModel()
    {
        require_once APP . 'model/employeemodel.php';
        // create new "model" (and pass the database connection)
        $this->model = new EmployeeModel($this->db);
    }
    /**
     * PAGE: index
     */
    public function index()
    {
        // getting all employees and amount of employees
        $employees = $this->model->getAllEmployees();
        $amount_of_employees = $this->model->getAmountOfEmployees();

       // load views. within the views we can echo out $employees and $amount_of_employees easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/employees/index.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * ACTION: addEmployee
     * This method handles what happens when you move to http://yourproject/employees/addemployee
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a employee" form on employees/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to employees/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addEmployee()
    {
        // if we have POST data to create a new employee entry
        if (isset($_POST["submit_add_employee"])) {
            // do addEmployee() in model/model.php
            $this->model->addEmployee($_POST["firstname"], $_POST["surname"], $_POST["category"],  $_POST["email"], $_POST["phone"], $_POST["started"]);
        }

        // where to go after employee has been added
        header('location: ' . URL . 'employees/index');
    }

    /**
     * ACTION: deleteEmployee
     * This method handles what happens when you move to http://yourproject/employees/deleteemployee
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a employee" button on employees/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to employees/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $employee_id Id of the to-delete employee
     */
    public function deleteEmployee($employee_id)
    {
        // if we have an id of a employee that should be deleted
        if (isset($employee_id)) {
            // do deleteEmployee() in model/model.php
            $this->model->deleteEmployee($employee_id);
        }

        // where to go after employee has been deleted
        header('location: ' . URL . 'employees/index');
    }

     /**
     * ACTION: editEmployee
     * This method handles what happens when you move to http://yourproject/employees/editemployee
     * @param int $employee_id Id of the to-edit employee
     */
    public function editEmployee($employee_id)
    {
        // if we have an id of a employee that should be edited
        if (isset($employee_id)) {
            // do getEmployee() in model/model.php
            $employee = $this->model->getEmployee($employee_id);

            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $employee easily
            require APP . 'view/_templates/header.php';
            require APP . 'view/employees/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            // redirect user to employees index page (as we don't have a employee_id)
            header('location: ' . URL . 'employees/index');
        }
    }
    
    /**
     * ACTION: updateEmployee
     * This method handles what happens when you move to http://yourproject/employees/updateemployee
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a employee" form on employees/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to employees/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateEmployee()
    {
        // if we have POST data to create a new employee entry
        if (isset($_POST["submit_update_employee"])) {
            // do updateEmployee() from model/model.php
            $this->model->updateEmployee($_POST["firstname"], $_POST["surname"],  $_POST["email"], $_POST["phone"], $_POST["category"], $_POST["started"], $_POST["left"],$_POST['employee_id']);
        }

        // where to go after employee has been added
        header('location: ' . URL . 'employees/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_employees = $this->model->getAmountOfEmployees();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_employees;
    }

}
