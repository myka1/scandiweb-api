<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Products.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate product object
  $product = new Product($db);

  // Get raw product data
  $data = json_decode(file_get_contents("php://input"));

  $product->sku = $data->sku;
  $product->name = $data->name;
  $product->price = $data->price;
  $product->type = $data->type;
  $product->attribute = $data->attribute;
  $product->value = $data->value;
  

  // Create product
  if($product->create()) {
    echo json_encode(
      array('message' => 'Product Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Product Not Created')
    );
  }

