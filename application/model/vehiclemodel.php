<?php

require_once "model.php";

class VehicleModel extends Model
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
    public function getAllVehicles()
    {
        $sql = "SELECT v.*, c.name AS `customer` FROM Vehicles AS v
LEFT JOIN Customers AS c ON c.id=v.customerId";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getVehiclesCustomer($customer_id)
    {
        $sql = "SELECT v.*, c.name AS `customer` FROM Vehicles AS v
LEFT JOIN Customers AS c ON c.id=v.customerId where v.customerId=".$this->db->quote($customer_id);
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getAllCustomers()
    {
       $sql="select id, `name` from `Customers`";
        $query = $this->db->prepare($sql);
        $query->execute();

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
    public function addVehicle($plate, $customer, $type)
    {
        $sql = "INSERT INTO `Vehicles` (`plate`, `customerid`, `type`) VALUES (
        ".$this->convertValue(strtoupper($plate)).", ".$this->convertValue($customer).", 
        ".$this->convertValue($type).")";
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
     * Delete a vehicle in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $vehicle_id Id of vehicle
     */
    public function deleteVehicle($vehicle_id)
    {
        $sql = "DELETE FROM `Vehicles` WHERE id = :vehicle_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':vehicle_id' => $vehicle_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a vehicle from database
     */
    public function getVehicle($vehicle_id)
    {
        $sql = "SELECT * FROM `Vehicles` WHERE id = :vehicle_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':vehicle_id' => $vehicle_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Update a vehicle in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $vehicle_id Id
     */
    public function updateVehicle($plate, $customer, $type, $vehicle_id)
    {
        $sql = "UPDATE `Vehicles` SET  `plate`= ".$this->convertValue(strtoupper($plate))
            .", `customerId` = ".$this->convertValue($customer).", `type` = ".
            $this->convertValue($type)." WHERE id = ".$vehicle_id;
      /*  $query = $this->db->prepare($sql);
        $parameters = array(':plate' => $this->convertValue(strtoupper($plate)),
            ':customer' => $this->convertValue($customer),
            ':typec' => $this->convertValue($type),
            ':vehicle_id' => $vehicle_id
        );  */
   //   echo $sql;
      $this->db->query($sql);


       // $query->execute($parameters);
    }

    public function getCustomerName($customer_id)
    {
        $sql="select `name` from Customers where id=".$this->db->quote($customer_id)." limit 1;";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->name;
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/vehicles.php for more)
     */
    public function getAmountOfVehicles()
    {
        $sql = "SELECT COUNT(id) AS `amount_of_vehicles` FROM `Vehicles`";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_vehicles;
    }

    public function getAmountOfVehiclesCustomer($customer_id)
    {
        $sql = "SELECT COUNT(id) AS `amount_of_vehicles` FROM `Vehicles` where `customerId`=".$this->db->quote($customer_id);
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_vehicles;
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
