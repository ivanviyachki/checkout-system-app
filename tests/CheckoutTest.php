<?php

namespace Tests;

use Checkout_System\Checkout;
use Checkout_System\Product;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    public function test_calculate_A()
    {
        $checkout = new Checkout();

        $car = array('A' => new Product('A'));

        $quantity = array('A' => 1);
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(50, $result);
    }

    public function test_calculate_AB()
    {
        $checkout = new Checkout();

        $car = array(
            'A' => new Product('A'),
            'B' => new Product('B')
        );
        
        $quantity = array(
            'A' => 1, 
            'B' => 1
        );
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(80, $result);
    }

    public function test_calculate_CDBA()
    {
        $checkout = new Checkout();

        $car = array(
            'C' => new Product('C'),
            'B' => new Product('B'), 
            'D' => new Product('D'), 
            'A' => new Product('A')
        );

        $quantity = array(
            'C' => 1, 
            'B' => 1,
            'D' => 1,
            'A' => 1
        );
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(110, $result );
    }

    public function test_calculate_AA()
    {
        $checkout = new Checkout();

        $car = array('A' => new Product('A'));

        $quantity = array('A' => 2);
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(100, $result);
    }

    public function test_calculate_AAA()
    {
        $checkout = new Checkout();

        $car = array('A' => new Product('A'));
        $quantity = array('A' => 3);
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(130, $result);
    }

    public function test_calculate_AAAA()
    {
        $checkout = new Checkout();

        $car = array('A' => new Product('A'));

        $quantity = array('A' => 4);
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(180, $result);
    }


    public function test_calculate_AAAB()
    {
        $checkout = new Checkout();

        $car = array(
            'A' => new Product('A'),
            'B' => new Product('B')
        );
        
        $quantity = array(
            'A' => 3, 
            'B' => 1
        );
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(160, $result);
    }

    public function test_calculate_AAABB()
    {
        $checkout = new Checkout();

        $car = array(
            'A' => new Product('A'),
            'B' => new Product('B')
        );
        
        $quantity = array(
            'A' => 3, 
            'B' => 2
        );
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(175, $result);
    }

    public function test_calculate_AAABBD()
    {
        $checkout = new Checkout();

        $car = array(
            'A' => new Product('A'),
            'B' => new Product('B'),
            'D' => new Product('D')
        );
        
        $quantity = array(
            'A' => 3, 
            'B' => 2,
            'D' => 1
        );
        
        $result = $checkout->calculate_total($car,$quantity );

        $this->assertEquals(185, $result);
    }
}