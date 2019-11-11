<?php

/**
 * Class Jobs
 *
 *
 */
class Jobs extends Controller
{
    

    function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }
    public function loadModel()
    {
        require_once APP . 'model/jobmodel.php';
        // create new "model" (and pass the database connection)
        $this->model = new JobModel($this->db);
    }
    /**
     * PAGE: index
     */
    public function index()
    {
        // getting all jobs and amount of jobs
        $jobs = $this->model->getAllJobs();
        $amount_of_jobs = $this->model->getAmountOfJobs();
       // load views. within the views we can echo out $jobs and $amount_of_jobs easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/jobs/index.php';
        require APP . 'view/_templates/footer.php';
    }
    public function customer($customer_id)
    {
        // getting all jobs and amount of jobs
        $customername=$this->model->getCustomerName($customer_id);
        $jobs = $this->model->getJobsCustomer($customer_id);
        $amount_of_jobs = $this->model->getAmountOfJobsCustomer($customer_id);
        // load views. within the views we can echo out $jobs and $amount_of_jobs easily
        require APP . 'view/_templates/header.php';
        require APP . 'view/jobs/customer.php';
        require APP . 'view/_templates/footer.php';
    }
    /**
     * ACTION: addJob
     * This method handles what happens when you move to http://yourproject/jobs/addjob
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a job" form on jobs/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to jobs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addJob()
    {
        // if we have POST data to create a new job entry
        if (isset($_POST["submit_add_job"])) {
            // do addJob() in model/model.php
            $this->model->addJob($_POST["vehicleId"], $_POST["customerId"]);
        }

        // where to go after job has been added
        header('location: ' . URL . 'jobs/index');
    }

    /**
     * ACTION: deleteJob
     * This method handles what happens when you move to http://yourproject/jobs/deletejob
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a job" button on jobs/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to jobs/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $job_id Id of the to-delete job
     */
    public function deleteJob($job_id)
    {
        // if we have an id of a job that should be deleted
        if (isset($job_id)) {
            // do deleteJob() in model/model.php
            $this->model->deleteJob($job_id);
        }

        // where to go after job has been deleted
        header('location: ' . URL . 'jobs/index');
    }

     /**
     * ACTION: editJob
     * This method handles what happens when you move to http://yourproject/jobs/editjob
     * @param int $job_id Id of the to-edit job
     */
    public function editJob($job_id)
    {
        // if we have an id of a job that should be edited
        if (isset($job_id)) {
            // do getJob() in model/model.php
            $job = $this->model->getJob($job_id);
            $employees = $this->model->getAllEmployees();
            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $job easily
            require APP . 'view/_templates/header.php';
            require APP . 'view/jobs/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            // redirect user to jobs index page (as we don't have a job_id)
            header('location: ' . URL . 'jobs/index');
        }
    }

    public function getVehicles($customerId)
    {
        echo json_encode($this->model->getVehicles($customerId));
    }
    /**
     * ACTION: updateJob
     * This method handles what happens when you move to http://yourproject/jobs/updatejob
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a job" form on jobs/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to jobs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateJob()
    {
        // if we have POST data to create a new job entry
        if (isset($_POST["submit_update_job"])) {
            // do updateJob() from model/model.php
            $this->model->updateJob($_POST["employeeId"], $_POST["orderId"],  $_POST["start"], $_POST["complected"], $_POST['job_id']);
        }

        // where to go after job has been added
        header('location: ' . URL . 'jobs/index');
    }

    public function completed($job_id){
        $this->model->setCompleted($job_id);
        header('location: ' . URL . 'jobs/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_jobs = $this->model->getAmountOfJobs();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_jobs;
    }

    public function generate($order_id)
    {
        $this->model->generateJob($order_id);
        header('location: ' . URL . 'jobs/index');
    }

}
