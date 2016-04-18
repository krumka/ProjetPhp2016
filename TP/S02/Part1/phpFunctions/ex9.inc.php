<?php //Fonctions
function today($dateOrHour){
    if($dateOrHour==1){
        return date("H:i");
    }
    return date("d-m-Y");
}
?>