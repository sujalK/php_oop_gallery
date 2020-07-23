<?php 

    class User extends Db_object {

        protected static $db_table= 'users';
        protected static $db_table_fields= ['username', 'first_name', 'last_name', 'password', 'user_image'];

        public $id;
        public $username;
        public $first_name;
        public $last_name;
        public $password;
        public $user_image;
        public $upload_directory= "images";
        public $image_placeholder= "https://via.placeholder.com/150";

        public function set_file($file) 
        {
            if(empty($file) || !$file || !is_array($file)) {
                $this->errors[]= "There was no file uploaded here";
                return false;
            } elseif($file['error'] != 0) {
                $this->errors[]= $this->upload_errors_array[$file['error']];
                return false;
            } else {
                $this->user_image   = $file['name'];
                $this->tmp_path     = $file['tmp_name'];
                $this->type         = $file['type'];
                $this->size         = $file['size'];
            }
        }
        
        public function save_user_and_image() 
        {
            
            // error checks
            if(!empty($this->errors)) {
                return false;
            }

            if(empty($this->user_image) || empty($this->tmp_path)) {
                $this->errors[]= "the file was not available";
                return false;
            }

            $target_path= SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
            
            if(file_exists($target_path)) {
                $this->errors[]= "The file {$this->user_image} already exists";
                return false;
            }

            if(move_uploaded_file($this->tmp_path, $target_path)) {
                if($this->create()) { 
                    unset($this->tmp_path); // unsetting temp path, because we don't need it anymore.
                    return true;
                }
            } else {
                $this->errors[]= "the file probably does not have permission."; 
            }
            
        }

        public function image_path_placeholder() 
        {
            return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
        }

        public static function verify_user($username, $password)
        {
            global $database;
            $username= $database->escape_string($username);
            $password= $database->escape_string($password);

            // $sql= "SELECT * FROM ". static::$db_table ." WHERE username='{$username}' AND password='{$password}'  LIMIT 1";
            $sql= "SELECT * FROM ". static::$db_table ." WHERE username='{$username}'";

            $the_result_array= self::find_by_query($sql);

            if($the_result_array && password_verify($password, $the_result_array[0]->password)) {
                return !empty($the_result_array) ? array_shift($the_result_array) : false ;
            }
        }

        public function ajax_save_user_image($user_image, $user_id) 
        {
            // $this->user_image= $user_image;
            // $this->id= $user_id;
            // $this->save();

            global $database;
            
            $user_image = $database->escape_string($user_image);
            $user_id    = $database->escape_string($user_id);

            $this->user_image = $user_image;
            $this->id         = $user_id;

            $sql  = "UPDATE ". self::$db_table . " SET user_image='{$this->user_image}' ";
            $sql .= " WHERE id= {$this->id}";

            $update_image= $database->query($sql);

            echo $this->image_path_placeholder();

        }

    }

?>