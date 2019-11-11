<?php

class Model
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
     * @param $value
     * @return string
     */
    public function convertValue($value)
    {
        if (is_null($value) || empty($value) || !strlen($value)) return "NULL";
        return $this->db->quote(strip_tags($value));
    }

 }
