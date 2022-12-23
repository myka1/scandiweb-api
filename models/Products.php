<?php
class Product {
  // DB stuff
  private $conn;
  private $table = 'products';

  // Product Properties
  public $id;
  public $sku;
  public $name;
  public $price;
  public $type;
  public $attribute;
  public $value;

  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get Products
  public function read() {
    // Create query
    $query = 'SELECT id, sku, name, price, type, attribute, value
                FROM ' . $this->table . '
                ORDER BY id DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Create Product
  public function create() {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET sku = :sku, name = :name,
              price = :price, type = :type, attribute = :attribute,
              value = :value ';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->sku = htmlspecialchars(strip_tags($this->sku));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->price = htmlspecialchars(strip_tags($this->price));
    $this->type = htmlspecialchars(strip_tags($this->type));
    $this->attribute = htmlspecialchars(strip_tags($this->attribute));
    $this->value = htmlspecialchars(strip_tags($this->value));

    // Bind data
    $stmt->bindParam(':sku', $this->sku);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':type', $this->type);
    $stmt->bindParam(':attribute', $this->attribute);
    $stmt->bindParam(':value', $this->value);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete Product
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function deleteSelected($ids) {
  
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
    $stmt = $this->conn->prepare($query);

    foreach ($ids as $id) {
      $stmt->execute([$id]);

      echo json_encode(
        " $id is deleted "
      );
    }
  }

}