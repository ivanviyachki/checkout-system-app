<?php 

declare(strict_types = 1);

use Checkout_System\Database;

namespace Checkout_System;

/**
 * Class responsible for products.
 */
class Products extends Database
{
    /**
     * Method used to return all products records from database
     *
     * @return array
     */
    public function getAllProducts(): array
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            return array();
        }

        $sql = "SELECT * FROM products";

        $result = $mysqli->query($sql);

        for ($x = 1; $x <= $mysqli->affected_rows; $x++) {
            $data[] = $result->fetch_assoc();
        }

        $mysqli->close();

        return $data;
    }

    /**
     * Method used to render products page
     *
     * @return void
     */
    public function render(): void
    {
        $products = $this->getAllProducts();
        
        require_once __DIR__ . '/../templates/products.php';
    }
}
