<?php 

declare(strict_types = 1);

use Checkout_System\Database;

namespace Checkout_System;

/**
 * Class responsible for orders.
 */
class Orders extends Database
{
    /**
     * Method used to return all orders records from database
     *
     * @return array
     */
    public function getAllOrders(): array 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            return array();
        }

        $sql = "SELECT * FROM orders";

        $result = $mysqli->query($sql);

        for ($x = 1; $x <= $mysqli->affected_rows; $x++) {
            $data[] = $result->fetch_assoc();
        }

        $mysqli->close();

        return $data;
    }
}