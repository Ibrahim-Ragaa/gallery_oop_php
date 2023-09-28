<?php

class Db_object{
    
    public $tmp_path;
    public $errors = array();
    public $upload_errors = array(
        UPLOAD_ERR_OK          => "There is no error.",
        UPLOAD_ERR_INI_SIZE    => "The uploaded file exceeds the_upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE   => "The uploaded file exceeds the_max_filesize directive that was specified in the HTML.",
        UPLOAD_ERR_PARTIAL     => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE     => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR  => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE  => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION   => "A php extension stopped the file upload."
    );
    
    
    
    
    public static function find_all(){
        return static::find_by_query("SELECT * FROM " .static::$db_table);        
    }
    
    
    public static function find_by_id($id){        
        $the_result_array = static::find_by_query("SELECT * FROM " .static::$db_table. " WHERE id=$id LIMIT 1 ");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }
    
    
    public static function find_by_query($sql){
        global $database;
        $result_set = $database->query($sql);
        $the_object_array= array();
        while($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = static::istantiation($row);
        }        
        return $the_object_array;
    }
        
    
    public static function istantiation($the_record){
        $calling_class = get_called_class();
        $the_object = new $calling_class;        
        foreach($the_record as $the_attribute => $value){
            if($the_object->has_the_attribute($the_attribute)){
                $the_object->$the_attribute = $value;
            }
        }        
        return $the_object;
    }
    
    
    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute , $object_properties);
    }
    
    
    private function properties(){
        $properties = array();
        foreach(static::$db_table_fields as $db_fields){
            if(property_exists($this,$db_fields)){
                $properties[$db_fields] = $this->$db_fields;
            }
        }
        return $properties;
    }
    
    
    protected function clean_properties(){
        global $database;
        $clean_properties = array();
        foreach($this->properties() as $key => $value){
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }
    
    
    public function save(){
        return isset($this->id) ? $this->update(): $this->create();
    }
    
    
    public function create(){
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " .static::$db_table. "(" .implode(",",array_keys($properties)). ") ";
        $sql .= "VALUES ('" .implode("','",array_values($properties)). "')";
        if($database->query($sql)){
            $this->id = $database->the_insert_id();
            return true;
        }else{
            return false;
        }
    }    
    
    
    public function update(){
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = array();
        foreach($properties as $key => $value){
            $properties_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " .static::$db_table. " SET ";
        $sql .= implode(", ",$properties_pairs);
//        $sql .= " username  = '" . $database->escape_string($this->username)  . "', ";
//        $sql .= " password  = '" . $database->escape_string($this->password)  . "', ";
//        $sql .= " firstname = '" . $database->escape_string($this->firstname) . "', ";
//        $sql .= " lastname  = '" . $database->escape_string($this->lastname)  . "' ";
        $sql .= " WHERE id  = "  . $database->escape_string($this->id);
        
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)== 1) ? true : false;
    }
    
    
    public function delete(){
        global $database;
        $sql = "DELETE FROM " .static::$db_table;
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $sql .= " LIMIT 1 ";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)== 1) ? true : false;
    }
    
    
    public static function count_all(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }
    
    
    
    
    
    
//deal with image
    public function set_image($image){
        if(empty($image) || !$image || !is_array($image)){
            $this->errors[] = "There was no image uploaded in here";
            return false;
        }elseif($image['error'] !=0){
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        }else{
            $this->image_name = basename($image['name']);
            $this->tmp_path = $image['tmp_name'];
            $this->type = $image['type'];
            $this->size = $image['size'];
        }
    }
    
    
    public function save_image(){
        if(!empty($this->errors)){
            return false;
        }
        if(empty($this->image_name) || empty($this->tmp_path)){
            $this->errors[] = "The file was not available";
            return false;
        }
        $target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->image_name;
        if(file_exists($target_path)){
            $this->errors[] = "The {$this->image_name} is already exists";
            return false;
        }
        if(move_uploaded_file($this->tmp_path,$target_path)){
            if($this->save()){
                unset($this->tmp_path);
                return true;
            }
        }else{
            $this->errors[] = "Error Error";
            return false;
        }
    }
    
    
    public function upload_image(){
        if(!empty($this->errors)){
            return false;
        }
        if(empty($this->image_name) || empty($this->tmp_path)){
            $this->errors[] = "The file was not available";
            return false;
        }
        $target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->image_name;
        if(file_exists($target_path)){
            $this->errors[] = "The {$this->image_name} is already exists";
            return false;
        }
        if(move_uploaded_file($this->tmp_path,$target_path)){
            unset($this->tmp_path);
            return true;
        }else{
            $this->errors[] = "Error Error";
            return false;
        }
    }

    
    
    public function delete_image(){
        if($this->delete()){
            $target_path = SITE_ROOT.DS.'admin'.DS.$this->image_path();
            return unlink($target_path) ? true : false;
        }
    }
    
    
    public function image_path(){
        return $this->upload_directory.DS.$this->image_name;
    }
    
    
    public function image_path_placeholder(){
        return empty($this->image_name) ? $this->upload_directory.DS.$this->image_placeholder : $this->upload_directory.DS.$this->image_name;
    }
    
    
    public function ajax_update_image($image_name, $id){
        global $database;
        $image_name = $database->escape_string($image_name);
        $id         = $database->escape_string($id);
        
        $this->image_name = $image_name;
        $this->id         = $id;
        
        $sql  = "UPDATE " . static::$db_table . " SET Image_name = '{$this->image_name}' ";
        $sql .= " WHERE id = {$this->id}";
        $update_image = $database->query($sql);
        
//        $this->save();
    }
    
    
    
    
//end of deal with image

    
    
    
//deal with files
//        public function set_file($file){
//        if(empty($file) || !$file || !is_array($file)){
//            $this->errors[] = "There was no file uploaded in here";
//            return false;
//        }elseif($file['error'] !=0){
//            $this->errors[] = $this->upload_errors[$file['error']];
//            return false;
//        }else{
//            $this->filename = basename($file['name']);
//            $this->tmp_path = $file['tmp_name'];
//            $this->type = $file['type'];
//            $this->size = $file['size'];
//        }
//    }
//    
//    
//    public function save_file(){
//        if($this->id){
//            $this->update_file();
//        }else{
//            if(!empty($this->errors)){
//                return false;
//            }
//            if(empty($this->filename) || empty($this->tmp_path)){
//                $this->errors[] = "The file was not available";
//                return false;
//            }
//            
//            $target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->filename;
//            if(file_exists($target_path)){
//                $this->errors[] = "The {$this->filename} is already exists";
//                return false;
//            }
//            if(move_uploaded_file($this->tmp_path,$target_path)){
//                if($this->save()){
//                    unset($this->tmp_path);
//                    return true;                    
//                }
//            }else{
//                $this->errors[] = "Error";
//                return false;
//            }        
//        }
//    }
//    
//    
//    public function delete_file(){
//        if($this->delete()){
//            $target_path = SITE_ROOT.DS.'admin'.DS.$this->file_path();
//            return unlink($target_path) ? true : false;
//        }
//    }
//    
//    
//    public function file_path(){
//        return $this->upload_directory.DS.$this->filename;
//    }
//end of deal with files

    
    
    
    public function test($test){
        echo $test;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}//end of Db_objects class
