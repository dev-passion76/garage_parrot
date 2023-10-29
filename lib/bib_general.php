<?php 

class POST{    
    public static function get($data){
        if (isset($_POST[$data]))
            return $_POST[$data];
         else
            return null;
    }
}

class GET{
    public static function get($data){
        if (isset($_GET[$data]))
            return $_GET[$data];
        else
            return null;
    }
}
?>