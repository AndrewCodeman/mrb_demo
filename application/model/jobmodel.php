<?php

require_once "model.php";

class JobModel extends Model
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
    public function getAllJobs()
    {
        $sql = "SELECT j.*, e.firstname, e.surname, e.category, c.`name` AS `customer`, v.plate, v.`type`, o.vehicleId
FROM Jobs AS j
LEFT JOIN Employees AS e ON e.id=j.employeeId
LEFT JOIN Orders AS o ON o.id=j.orderId
LEFT JOIN Customers AS c ON c.id=o.customerId
LEFT JOIN Vehicles AS v ON v.id=o.vehicleId";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getJobsEmployee($employee_id)
    {
        $sql = "SELECT j.*, e.firstname, e.surname, e.category, c.`name` AS `customer`, v.plate, v.`type`, o.vehicleId
FROM Jobs AS j
LEFT JOIN Employees AS e ON e.id=j.employeeId
LEFT JOIN Orders AS o ON o.id=j.orderId
LEFT JOIN Customers AS c ON c.id=o.customerId
LEFT JOIN Vehicles AS v ON v.id=o.vehicleId
WHERE j.employeeId=".$this->db->quote($employee_id);
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
    public function calcJobDuration($order_id) {
        $sql="SELECT v.type,
case
	when v.`type`='Car' then 120
	when v.`type`='Motorbike' then 30
	when v.`type`='Bus' then 240 
END AS `minutes`
FROM Vehicles AS v
JOIN Orders AS o ON o.vehicleId=v.id
WHERE o.id=".$this->db->quote($order_id);
        $res=$this->db->query($sql)->fetch();
        return $res->minutes;
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
    public function addJob($employee, $order, $start)
    {
        $duration = $this->calcJobDuration($order);
        
        $sql = "INSERT INTO `Jobs` (`employeeId`, `orderId`, `start_at`, `duration`) VALUES (
        ".$this->convertValue($employee).", ".$this->convertValue($order).", ".$this->convertValue($duration).")";

        $this->db->query($sql);
    }

    /**
     * Delete a job in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $job_id Id of job
     */
    public function deleteJob($job_id)
    {
        $sql = "DELETE FROM `Jobs` WHERE id = :job_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':job_id' => $job_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a job from database
     */
    public function getJob($job_id)
    {
        $sql = "SELECT j.*, e.firstname, e.surname, e.category, c.`name` AS `customer`, v.plate, v.`type`, o.vehicleId
FROM Jobs AS j
LEFT JOIN Employees AS e ON e.id=j.employeeId
LEFT JOIN Orders AS o ON o.id=j.orderId
LEFT JOIN Customers AS c ON c.id=o.customerId
LEFT JOIN Vehicles AS v ON v.id=o.vehicleId
WHERE j.Id = ".$this->db->quote($job_id)." LIMIT 1";
        /*
        $query = $this->db->prepare($sql);
        $parameters = array(':job_id' => $job_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();  */
        return $this->db->query($sql)->fetch();
    }

 

    /**
     * Update a job in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $job_id Id
     */
    public function updateJob($employee, $order, $start, $completed, $job_id)
    {
        $sql="SELECT v.id, v.type,
case
	when v.`type`='Car' then 120
	when v.`type`='Motorbike' then 30
	when v.`type`='Bus' then 240 
END AS `minutes`,
case
	when v.`type`='Car' then '\'ManagerB\',\'MechanicA\',\'MechanicB\''
	when v.`type`='Motorbike' then '\'MechanicA\',\'MechanicB\''
	when v.`type`='Bus' then '\'MechanicB\''
END AS `category`
FROM Vehicles AS v
JOIN Orders AS o ON o.vehicleId=v.id
WHERE o.id=".$this->db->quote($order);
        $vehicle=$this->db->query($sql)->fetch();
        $duration=$vehicle->minites;
        $end=$start +($duration * 60);

        $end=$this->checkWorkTime($end,(true));
        $sql = "UPDATE `Jobs` SET  `employeeId`= ".$this->convertValue($employee).", 
        `orderId` = $this->convertValue($order), `start_at` = ".$this->convertValue($start).", 
        `completed_at` = ".$this->convertValue($completed).", `duration`=".$this->convertValue($duration)." WHERE id = ".$job_id;

        $this->db->query($sql);
        if ($this->convertValue($completed)!="NULL") {
            $sql = "update `Orders` set `completed_at` = ".$this->convertValue($completed) ." WHERE id = ".$order;
            $this->db->query($sql);
        }
    }

    public function setCompleted($job) {
        $sql = "UPDATE `Jobs` SET  `completed_at` = NOW() WHERE id = ".$job;

        $this->db->query($sql);

        $res=$this->db->query("select `orderId` from `Jobs`WHERE id = ".$job)->fetch();

        $sql = "update `Orders` set `completed_at` = NOW() WHERE id = ".$res->orderId;
        $this->db->query($sql);

    }
    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/jobs.php for more)
     */
    public function getAmountOfJobs()
    {
        $sql = "SELECT COUNT(id) AS `amount_of_jobs` FROM `Jobs`";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_jobs;
    }
    
    public function getEmployeeName($employee_id)
    {
        $sql="select concat(`firstname`,' ',`surname`) as `name` from Employees where id=".$this->db->quote($employee_id)." limit 1;";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->name;
    }

    public function getAmountOfJobsEmployee($employee_id)
    {
        $sql = "SELECT COUNT(id) AS `amount_of_jobs` FROM `Jobs` where employeeId=".$this->db->quote($employee_id);
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_jobs;
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

    public function checkWorkTime($value, $fulltime=true) {
        $date=date("d-m-Y", $value);
        $start=strtotime($date." 10:00:00");
        $end=$fulltime?strtotime($date." 18:00:00"):strtotime($date." 14:00:00");
        if ($value>$end) {
            $start+=86400;
            $delta=$value-$end;
            $value=$start+$delta;
        }
        if ($value<$start){
            $prevdate=$end-86400;
            $delta=$value-$prevdate;
           // $start+=86400;
            $value=$start;
        }
        return  $value;
    }

    public function generateJob($order){
        $sql="SELECT v.id, v.type,
case
	when v.`type`='Car' then 120
	when v.`type`='Motorbike' then 30
	when v.`type`='Bus' then 240 
END AS `minutes`,
case
	when v.`type`='Car' then '\'ManagerB\',\'MechanicA\',\'MechanicB\''
	when v.`type`='Motorbike' then '\'MechanicA\',\'MechanicB\''
	when v.`type`='Bus' then '\'MechanicB\''
END AS `category`
FROM Vehicles AS v
JOIN Orders AS o ON o.vehicleId=v.id
WHERE o.id=".$this->db->quote($order);
        $vehicle=$this->db->query($sql)->fetch();

        $sql1="SELECT j.*, e.firstname, e.surname, e.category, v.`type`, o.vehicleId
FROM Jobs AS j
LEFT JOIN Employees AS e ON e.id=j.employeeId
LEFT JOIN Orders AS o ON o.id=j.orderId
LEFT JOIN Vehicles AS v ON v.id=o.vehicleId
WHERE e.category IN ('ManagerB','MechanicA','MechanicB') 
AND j.id in (select max(id) from jobs group by employeeId)
UNION
SELECT 0 AS `id`, ec.id AS `empoyeeId`, null AS `orderId`, null AS `start_at`, NULL AS `completed_at`, NULL AS `duration`, ec.started_at AS `end_at`, ec.firstname, ec.surname, ec.category,
  NULL AS `type`,   NULL AS `venicleId`
FROM Employees AS ec
WHERE ec.id NOT IN (SELECT COUNT(oo.id)  FROM Jobs AS oo WHERE oo.employeeId=ec.id GROUP BY oo.employeeId )
ORDER BY end_at ASC LIMIT 1";
      //  echo $sql1;
        $free=$this->db->query($sql1)->fetch();

        if (strtotime($free->end_at) < time()) {

           $start=time()+60;
        }  else {
           $start=strtotime($free->end_at)+60;
        }

        $start=$this->checkWorkTime($start,(($free->category=="ManagerB")?false:true));
        $end=$start +($vehicle->minutes * 60);

        $end=$this->checkWorkTime($end,(($free->category=="ManagerB")?false:true));

        $sql = "INSERT INTO `Jobs` (`employeeId`, `orderId`, `start_at`, `duration`, `end_at`) VALUES (
        ".$this->convertValue($free->employeeId).", ".$this->convertValue($order).", ".$this->convertValue(date('Y-m-d H:i:s',$start))
            .", ".$this->convertValue($vehicle->minutes).", ".$this->convertValue(date('Y-m-d H:i:s',$end)).")";
        //echo $sql;
        $this->db->query($sql);
    }
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
}
