<?php

require_once "model.php";

class OrderModel extends Model
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
    public function getAllOrders()
    {
        $sql = "SELECT o.*, c.name AS `customer`, v.`type` AS `vehicleType`, v.plate AS `vehiclePlate`,
IFNULL((SELECT j.id FROM Jobs AS j WHERE j.orderId=o.id),0) AS 'job'
FROM Orders AS o
LEFT JOIN Customers AS c ON o.customerId = c.id
LEFT JOIN Vehicles AS v ON v.id = o.vehicleId";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getOrdersCustomer($customer_id)
    {
        $sql = "SELECT o.*, c.name AS `customer`, v.`type` AS `vehicleType`, v.plate AS `vehiclePlate`,
IFNULL((SELECT j.id FROM Jobs AS j WHERE j.orderId=o.id),0) AS 'job'
FROM Orders AS o
LEFT JOIN Customers AS c ON o.customerId = c.id
LEFT JOIN Vehicles AS v ON v.id = o.vehicleId where o.customerId=".$this->db->quote($customer_id);
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
    public function addOrder($vehicle, $customer)
    {
        $sql = "INSERT INTO `Orders` (`vehicleId`, `customerId`) VALUES (
        ".$this->convertValue($vehicle).", ".$this->convertValue($customer).")";
       
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
     * Delete a order in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $order_id Id of order
     */
    public function deleteOrder($order_id)
    {
        $sql = "DELETE FROM `Orders` WHERE id = :order_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':order_id' => $order_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a order from database
     */
    public function getOrder($order_id)
    {
        $sql = "SELECT o.*, c.name AS `customer`, v.`type` AS `vehicleType`, v.plate AS `vehiclePlate`
FROM Orders AS o
LEFT JOIN Customers AS c ON o.customerId = c.id
LEFT JOIN Vehicles AS v ON v.id = o.customerId WHERE o.id = :order_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':order_id' => $order_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * @param $order_id
     * @return array
     */
    public function getVehicles($order_id)
    {
        $sql = "SELECT * FROM Vehicles WHERE customerId= :order_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':order_id' => $order_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetchAll();
    }

    /**
     * Update a order in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $order_id Id
     */
    public function updateOrder($vehicle, $customer, $created, $completed, $order_id)
    {
        $sql = "UPDATE `Orders` SET  `vehicleId`= :vehicle, `customerId` = :customer, `created_at` = :created, `completed_at` = :completed WHERE id = :order_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':vehicle' => $this->convertValue($vehicle),
            ':customer' => $this->convertValue($customer),
            ':created' => $this->convertValue($created),
            ':completed' => $this->convertValue($completed),
            ':order_id' => $order_id
        );


        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/orders.php for more)
     */
    public function getAmountOfOrders()
    {
        $sql = "SELECT COUNT(id) AS `amount_of_orders` FROM `Orders`";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_orders;
    }
    
    public function getCustomerName($customer_id)
    {
        $sql="select `name` from Customers where id=".$this->db->quote($customer_id)." limit 1;";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->name;
    }

    public function getAmountOfOrdersCustomer($customer_id)
    {
        $sql = "SELECT COUNT(id) AS `amount_of_orders` FROM `Orders` where customerId=".$this->db->quote($customer_id);
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_orders;
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
