<?php 

    class Db_object {
        
        protected static $db_table= '';
        protected static $db_table_fields= [];
        
        public $errors= [];
        public $upload_errors_array = [
            UPLOAD_ERR_OK         => 'There is no error',
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.'
        ];

        public static function find_all() 
        {
            return self::find_by_query("SELECT * FROM ". static::$db_table);
        }
        
        public static function find_by_id($id) 
        {
            global $database;
            $the_result_array= self::find_by_query("SELECT * FROM ". static::$db_table ." WHERE id={$database->escape_string($id)}");
            return !empty($the_result_array) ? array_shift($the_result_array) : false;
        }

        public static function find_by_query($sql) 
        {
            global $database;
            $result_set         = $database->query($sql);
            $the_object_array   = [];

            while($row= $result_set->fetch_array()) {
                $the_object_array[]= self::instantiation($row);
            }

            return $the_object_array;
        }

        public static function instantiation($the_record) 
        {
            $the_object= new static;
            foreach($the_record as $k => $v) {
                if(property_exists($the_object, $k)) {
                    $the_object->$k= $v;
                }
            }
            return $the_object;
        }

        public function save() 
        {
            return isset($this->id) ? $this->update() : $this->create();
        }

        public function properties() 
        {
            // return get_object_vars($this);
            $properties= [];

            foreach(static::$db_table_fields as $db_field) {
                if(property_exists($this, $db_field)) {
                    $properties[$db_field]= $this->$db_field;
                }
            }

            return $properties;
        }

        public function create()
        {
            global $database;

            $properties= $this->clean_properties();

            $sql  = "INSERT INTO ". static::$db_table ."(" . implode(', ', array_keys($properties)) .") ";
            $sql .= " VALUES('". implode("', '", array_values($properties)) ."')";

            if($database->query($sql)) {
                $this->id= $database->the_insert_id();
                return true;
            } else {
                return false;
            }
        }

        // update
        public function update() 
        {
            global $database;

            $properties= $this->clean_properties();

            $properties_pairs= [];

            foreach($properties as $key => $value) {
                $properties_pairs[]= "{$key}= '$value'";
            }

            $sql     =  "UPDATE ". static::$db_table ." SET ";
            $sql    .=  implode(', ', $properties_pairs);
            $sql    .=  " WHERE id  =  {$database->escape_string($this->id)}";

            $database->query($sql);

            // return (mysqli_affected_rows($database->connection) == 1) ? true : false;
            return ($database->affected_rows() == 1) ? true : false;
        }

        // delete
        public function delete()
        {
            global $database;
            $sql = "DELETE FROM ". static::$db_table ." WHERE id={$database->escape_string($this->id)} LIMIT 1";
            $database->query($sql);
            return ($database->affected_rows() == 1) ? true  : false;
        }

        public static function count_all() 
        {
            global $database;
            $sql        = "SELECT * FROM ". static::$db_table;
            $result_set = $database->query($sql);
            return $result_set->num_rows;
            // return count($result_set->fetch_array());
        }

        protected function clean_properties()
        {
            global $database;
            $clean_properties= [];

            foreach($this->properties() as $key=>$value) {
                $clean_properties[$key]= $database->escape_string($value);
            }

            return $clean_properties;
        }

    }

?>