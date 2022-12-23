<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Products.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate product object
  $product = new Product($db);

  // product query
  $result = $product->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any products
  if($num > 0) {
    // Products array
    $product_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $product_item = array(
        'id' => $id,
        'sku' => $sku,
        'name' => $name,
        'price' => $price,
        'type' => $type,
        'attribute' => $attribute,
        'value' => $value
      );

      // Push to "data"
      array_push($product_arr, $product_item);
    }

    // Turn to JSON & output
    echo json_encode($product_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
