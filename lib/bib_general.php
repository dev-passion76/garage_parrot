<?php 

class POST{

    public static function get($data){
        if (isset($_POST[$data]))
            return $_POST[$data];
        else
            return null;
    }
}
?>