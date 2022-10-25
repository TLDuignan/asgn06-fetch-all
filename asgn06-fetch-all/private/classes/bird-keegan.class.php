<?php

class Bird {

  static protected $database;

  static public function set_database($database) {
    self::$database = $database;
  }
  static public function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if (!$result) {
      exit("Database query failed.");
    }
    $objectArray = [];
    while ($record = $result->fetch_assoc()){
      $objectArray[] = self::instantiate($record);
    }
    
    $result->free();
    return $objectArray;
  }
  static public function find_all() {
    $sql = "SELECT * FROM birds ";
    return self::find_by_sql($sql);
  }
  static protected function instantiate($record) {
    $object = new self;
    foreach($record as $property => $value) {
      if(property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }
  
  static public function find_by_id($id)
  {
      $sql = "SELECT * FROM birds ";
      $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
      $obj_array = self::find_by_sql($sql);
      if (!empty($obj_array)) {
          return array_shift($obj_array);
      } else {
          return false;
      }
  }
  public $id;
  public $common_name;
  public $habitat;
  public $food;
  public $nest_placement;
  public $behavior;
  protected $conservation_id;
  public $backyard_tips;

  protected const CONSERVATION = [
    1 => 'Low',
    2 => 'Moderate',
    3 => 'High',
    4 => 'Extreme',
  ];

  //Function for constructing class objects
  // public function __construct($args=[]) {
  //   $this -> common_name = $args['common_name'] ?? '';
  //   $this -> habitat = $args['habitat'] ?? '';
  //   $this -> food = $args['food'] ?? '';
  //   $this -> nest_placement = $args['nest_placement'] ?? '';
  //   $this -> behavior = $args['behavior'] ?? '';
  //   $this -> conservation_id = $args['conservation_id'] ?? 1;
  //   $this -> backyard_tips = $args['backyard_tips'] ?? '';

  //   foreach($args as $k => $v) {
  //     if(property_exists($this, $k)) {
  //       $this->$k = $v;
  //     }
  //   }
  // }
  public function name()
  {
      return "{$this->common_name}";
  }

  //Function for condition id checks/fallback
  public function conservation() {
    if ($this -> conservation_id > 0) {
      return self::CONSERVATION[$this -> conservation_id];
    } else {
      return "Unknown";
    }
  }
}

?>
