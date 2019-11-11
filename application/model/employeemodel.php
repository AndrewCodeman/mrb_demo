<?php

require_once "model.php";

class EmployeeModel extends Model
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Get all songs from database
     */
    public function getAllEmployees()
    {
        $sql = "SELECT c.*, 
(SELECT COUNT(oo.id)  FROM Jobs AS oo WHERE oo.employeeId=c.id AND oo.completed_at IS null) AS `OpenJobs`,
(SELECT COUNT(oc.id)  FROM Jobs AS oc WHERE oc.employeeId=c.id AND oc.completed_at IS not null) AS `ClosedJobs`
FROM Employees AS c";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Add a song to database
     * TODO put this explanation into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     */
    public function addEmployee($firstname, $surname, $category, $email='', $phone='', $started='')
    {
        $sql = "INSERT INTO `Employees` (`firstname`, `surname`, `email`, `phone`, `category`, `started_at`) VALUES (
        ".$this->convertValue($firstname).", ".$this->convertValue($surname).", 
        ".$this->convertValue($email).", ".$this->convertValue($phone).", 
        ".$this->convertValue($category).", 
        ".$this->convertValue($started).")";
     //   $query = $this->db->prepare($sql);
        /*
        $parameters = array(':namec' => ,
            ':address' => $this->convertValue($address),
            ':email' => $this->convertValue($email),
            ':phone' => $this->convertValue($phone),
            ':responseMethod' => $this->convertValue($respondMethod)
        );   */

       // echo $sql;
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

       // $query->execute($parameters);
        $this->db->query($sql);
    }

    /**
     * Delete a employee in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $employee_id Id of employee
     */
    public function deleteEmployee($employee_id)
    {
        $sql = "DELETE FROM `Employees` WHERE id = :employee_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':employee_id' => $employee_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a employee from database
     */
    public function getEmployee($employee_id)
    {
        $sql = "SELECT * FROM `Employees` WHERE id = :employee_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':employee_id' => $employee_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Update a employee in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $employee_id Id
     */
    public function updateEmployee($firstname, $surname, $email, $phone, $category, $started, $left, $employee_id)
    {
        $sql = "UPDATE `Employees` SET  `firstname`= ".$this->convertValue($firstname).", `surname` = ".$this->convertValue($surname).
            ", `email` = ".$this->convertValue($email).", `phone` = ".$this->convertValue($phone).
            ", `category` = ".$this->convertValue($category).", `started_at` = ".$this->convertValue($started).
            ", `left_at` = ".$this->convertValue($left)." WHERE id = ".$employee_id;
       // echo $sql;
        /*
        $query = $this->db->prepare($sql);
        $parameters = array(':firstname' => $this->convertValue($firstname),
            ':surname' => $this->convertValue($surname),
            ':email' => $this->convertValue($email),
            ':phone' => $this->convertValue($phone),
            ':category' => $this->convertValue($category),
            ':started' => $this->convertValue($started),
            ':left' => $this->convertValue($left),
            ':employee_id' => $employee_id
        );


       // $query->execute($parameters);
        */
        $this->db->query($sql);
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/employees.php for more)
     */
    public function getAmountOfEmployees()
    {
        $sql = "SELECT COUNT(id) AS `amount_of_employees` FROM `Employees`";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_employees;
    }

    /**
     * @param $value
     * @return string
     */
    public function convertValue($value)
    {
        if (is_null($value) || empty($value) || (strlen($value)<0)) return "NULL";
        return $this->db->quote(strip_tags($value));
    }
}
