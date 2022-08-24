<?php

require_once('config.php');

/* Create connection */
$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD);

/* Check connection */
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

/* SQL query */
$sql = "DROP DATABASE IF EXISTS " . $mysqli->real_escape_string(DB_NAME);

/* Drop database if exists */
if ($mysqli->query($sql)) {
    echo "Database dropped successfully \n";
} else {
    die("Error dropping database: " . $mysqli->error);
}

/* SQL query */
$sql = "CREATE DATABASE " . $mysqli->real_escape_string(DB_NAME);

/* Create database if exists */
if ($mysqli->query($sql)) {
    echo "Database created successfully \n";
} else {
    die("Error creating database: " . $mysqli->error);
}

$mysqli->close();

/* Create connection with the new datebase*/
$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

/* Check database connection */
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

/* Create new tables*/
$tables['products'] = "CREATE TABLE IF NOT EXISTS products (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        sku VARCHAR(30) NOT NULL,
        unit_price INT(6) NOT NULL,
        special_price VARCHAR(50)
    )";
$tables['orders'] = "CREATE TABLE IF NOT EXISTS orders (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        total_price INT(10) NOT NULL
    )";

$tables['order_meta'] = "CREATE TABLE IF NOT EXISTS order_meta (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        order_id INT(6) NOT NULL,
        item_sku VARCHAR(30) NOT NULL,
        quantity INT(10) NOT NULL,
        total_price INT(6) NOT NULL
    )";

/* Create tables */  
foreach ($tables as $key => $sql) {
    
    if($mysqli->query($sql)) {
        echo "Table " . $key . ": Created successfully \n";
    } else {
        die("Table " . $key . " : Creating error: " . $mysqli->error);
    }
}  

/* Products insert query */
$sql = "INSERT INTO products (name, sku, unit_price, special_price) VALUES
    ('Product A', 'A', 50, '3/130'),
    ('Product B', 'B', 30, '2/45'),
    ('Product C', 'C', 20, null ),
    ('Product D', 'D', 10, null )";

if ($mysqli->query($sql)) {
    echo "Products added successfully. \n";
} else {
    die("Adding products error:" . $mysqli->error);
}

$mysqli->close();
