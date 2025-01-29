<?php
function onlyText($value){
    return preg_match('/^[A-Z]+$/i',$value);

}
function validateLength($value,$min,$max){
    return strlen($value)<$min?1:( strlen($value)>$max?2:0);
}
function verifyPassword($value){
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',$value);
   
}
?>