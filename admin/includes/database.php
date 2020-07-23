<?php 

    require_once("config.php");

    class Database {

        private $connection;

        public function __construct()
        {
            $this->open_db_connection();
        }

        public function open_db_connection()
        {
            $this->connection= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $this->connection->query("SET SESSION sql_mode = ''");
            if($this->connection->connect_errno) {
                die('Database connection failed badly'. $this->connection->connect_error);
            }
        }
        
        public function query($sql) 
        {
            $result= $this->connection->query($sql);
            $this->confirm_query($result);
            return $result;
        }

        private function confirm_query($result) 
        {
            if(!$result) {
                die('Query Failed '. '(' . $this->connection->errno. ') ( '. $this->connection->error . ' ) ' );
            }
        }

        public function escape_string($string) 
        {
            return $this->connection->escape_string($string);
        }

        public function the_insert_id() 
        {
            return $this->connection->insert_id;
        }

        public function affected_rows() 
        {
            return $this->connection->affected_rows;
        }
        
    }

    $database= new Database();

?>