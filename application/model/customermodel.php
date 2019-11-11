<?php

require_once "model.php";

class CustomerModel extends Model
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
    public function getAllCustomers()
    {
        $sql = "SELECT c.*, (SELECT COUNT(v.id)  FROM Vehicles AS v WHERE v.customerId=c.id) AS `vehicles`,
(SELECT COUNT(oo.id)  FROM Orders AS oo WHERE oo.customerId=c.id AND oo.completed_at IS null) AS `OpenOrders`,
(SELECT COUNT(oc.id)  FROM Orders AS oc WHERE oc.customerId=c.id AND oc.completed_at IS not null) AS `ClosedOrders`
FROM `Customers` AS c";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
    public function getAllVehicles($customer_id)
    {
       return 0;
    }
    public function getAllOrders($customer_id)
    {
       return 0;
    }
    /**
     * Replaces any parameter placeholders in a query with the value of that
     * parameter. Useful for debugging. Assumes anonymous parameters from
     * $params are are in the same order as specified in $query
     *
     * @param string $query The sql query with parameter placeholders
     * @param array $params The array of substitution parameters
     * @return string The interpolated query
     */
    public static function interpolateQuery($query, $params) {
        $keys = array();

        # build a regular expression for each parameter
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }
        }

        $query = preg_replace($keys, $params, $query, 1, $count);

        #trigger_error('replaced '.$count.' keys');

        return $query;
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
    public function addCustomer($name, $address, $email, $phone, $respondMethod)
    {
        $sql = "INSERT INTO `Customers` (`name`, `address`, `email`, `phone`, `respondMethod`) VALUES (
        ".$this->convertValue($name).", ".$this->convertValue($address).", 
        ".$this->convertValue($email).", ".$this->convertValue($phone).", 
        ".$this->convertValue($respondMethod).")";
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
     * Delete a customer in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $customer_id Id of customer
     */
    public function deleteCustomer($customer_id)
    {
        $sql = "DELETE FROM `Customers` WHERE id = :customer_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':customer_id' => $customer_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a customer from database
     */
    public function getCustomer($customer_id)
    {
        $sql = "SELECT * FROM `Customers` WHERE id = :customer_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':customer_id' => $customer_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Update a customer in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $customer_id Id
     */
    public function updateCustomer($name, $address, $email, $phone, $respondMethod, $customer_id)
    {
        $sql = "UPDATE `Customers` SET  `name`= :namec, `address` = :address, `email` = :email, `phone` = :phone, `respondMethod` = :respondMethod WHERE id = :customer_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':namec' => $this->convertValue($name),
            ':address' => $this->convertValue($address),
            ':email' => $this->convertValue($email),
            ':phone' => $this->convertValue($phone),
            ':responseMethod' => $this->convertValue($respondMethod),
            ':customer_id' => $customer_id
        );


        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/customers.php for more)
     */
    public function getAmountOfCustomers()
    {
        $sql = "SELECT COUNT(id) AS `amount_of_customers` FROM `Customers`";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_customers;
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
