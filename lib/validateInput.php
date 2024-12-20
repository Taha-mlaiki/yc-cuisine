<?php 
    function validateInput ($input){
        $input = trim($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>