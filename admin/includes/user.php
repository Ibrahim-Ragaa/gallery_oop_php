<?php

class User extends Db_object {
    
    
    protected static $db_table = "users";
    protected static $db_table_fields = array('username','password','firstname','lastname','image_name');
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $image_name;
    public $image_placeholder = "placeholder.jpg";
    public $upload_directory = "images";
    
    
    
    
    
    public static function verify_user($username,$password){
        global $database;
        
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        
        $sql = "SELECT * FROM " .self::$db_table. " WHERE ";
        $sql .= "username='{$username}' ";
        $sql .= "AND password='{$password}' ";
        $sql .= "LIMIT 1 ";
        
        $the_result_array = self::find_by_query($sql);
        
        return !empty($the_result_array) ? array_shift($the_result_array) : false;        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
} //end user class
