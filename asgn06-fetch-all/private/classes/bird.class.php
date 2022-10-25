<?php

 class Bird {
    // START OF ACTIVE RECORD CODE //
    static protected $database;

    static public function set_database($database) {
      self::$database = $database;
    }

    static public function find_by_sql($sql) {
      //echo $sql; exit;
      $result = self::$database->query("Select * from birds ");
      // var_dump($result); exit;
      if(!$result) {
        exit("Database query failed.");
      }
      $object_array = [];
      while($record = $result->fetch_assoc()) {
        $object_array[] = self::instantiate($record);
  
      }
      $result->free();
      //var_dump($object_array);
      return $object_array;
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

    static public function find_by_id($id) {
     // REMBMER TO CHANGE THIS BACK TO BIRDS
      $sql = "SELECT * FROM birds ";
      $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
      $obj_array = self::find_by_sql($sql);
      if(!empty($obj_array)) {
        return array_shift($obj_array);
      } else {
        return false;
      }
    }

    public $id;
    public $common_name;
    public $habitat;
    public $food;
    public $nest_palcement;
    public $behavior;
    public $backyard_tips;
    protected $conservation_id;

    protected const CONSERVATION_OPTIONS = [ 
        1 => "Low concern",
        2 => "Medium concern",
        3 => "High concern",
        4 => "Extreme concern"
    ];

//     public function __construct($args=[]) {
//         $this->common_name = $args['common_name'] ?? '';
//         $this->habitat = $args['habitat'] ?? '';
//         $this->food = $args['food'] ?? '';
//         $this->nest_palcement = $args['nest_palcement'] ?? '';
//         $this->behavior = $args['behavior'] ?? '';
//         $this->backyard_tips = $args['backyard_tips'] ?? '';
//         $this->conservation_id = $args['conservation_id'] ?? '';
// // Added by cw
//         foreach($args as $k => $v) {
//           if(property_exists($this, $k)) {
//             $this->$k = $v;
//           }
//         }
    // }

    public function conservation() {
        // echo self::CONSERVATION_OPTIONS[$this->conservation_id];
        if( $this->conservation_id > 0 ) {
            return self::CONSERVATION_OPTIONS[$this->conservation_id];
        } else {
            return "Unknown";
        }
    }


}