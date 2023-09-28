<?php

class Photo extends Db_object {
    
    
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id','title','description','image_name','type'.'size');
    public $id;
    public $title;
    public $description;
    public $type;
    public $size;
    public $image_name;
    public $image_placeholder = "placeholder.jpg";
    public $upload_directory = "images";
    
    
    
    
    

    
    
    
    
    
    
    
}//end of class photo




?>