<?php

declare(strict_types = 1);

use Checkout_System\Database;

namespace Checkout_System;

/**
 * Class responsible product.
 */
class Product extends Database
{
    /**
     * SKU
     * 
     * @var string
     */
    protected string $sku;

    /**
     * Price
     * 
     * @var int
     */
    protected int $price;

    /**
     * Price
     * 
     * @var array
     */
    protected array $discount;

    public function __construct(string $sku) 
    {
        parent::__construct();

        $this->sku = $sku;
        $this->setPrice();
        $this->setDiscount();
    }

    /**
     * Get prodcut SKU
     * 
     * @return string
     */
    public function getSku(): string 
    {
        return $this->sku;
    }

    /**
     * Get prodcut price
     * 
     * @return int
     */
    public function getPrice(): int 
    {
        return $this->price;
    }

    /**
     * Get product price
     * 
     * @return array
     */
    public function getDiscount(): array 
    {
        return $this->discount;
    }

    /**
     * Set product price
     * 
     * @return void
     */
    private function setPrice(): void 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            $this->price = -1;
        } else {
            $stmt = $mysqli->prepare("SELECT unit_price FROM products WHERE sku=? LIMIT 1");
        
            $stmt->bind_param('s', $this->sku);
    
            $stmt->execute();
            
            $result = $stmt->get_result();
    
            $this->price = intval($result->fetch_row()[0]) ?? 0;
        }

        $mysqli->close();
    }

    /**
     * Set product discount
     * 
     * @return void
     */
    private function setDiscount(): void 
    {
        $mysqli = $this->connect();

        if ($mysqli->connect_error) {
            $this->discount = array();
        } else {
            $stmt = $mysqli->prepare("SELECT special_price FROM products WHERE sku=? LIMIT 1");
            
            $stmt->bind_param('s', $this->sku);

            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $discount = $result->fetch_row()[0];

            if ($discount != null) {
                $this->discount = explode('/', strval($discount));
            } else {
                $this->discount = array();
            }
        }

        $mysqli->close();
    }

}
