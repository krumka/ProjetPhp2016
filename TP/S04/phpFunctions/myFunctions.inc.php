<?php //Fonctions
function today($dateOrHour){
    if($dateOrHour==1){
        return "<span id=hour>".date("H:i")."</span>";
    }
    return "<span id=date>".date("d-m-Y")."</span>";
}
function head($title, $css){
    $head = "<!DOCTYPE html>\n<html>\n\t<head>\n\t\t<meta charset=\"utf-8\">";
    $head .= "\n\t\t<meta author=\"Rémy Lambinet\">";
    $head .= "\n\t\t<title>".$title."</title>";
    $head .= "\n\t\t<link href=\"".$css."\" rel=\"stylesheet\" type=\"text/css\">";
    $head .= "\n\t</head>";
    return $head;
}
function body($content){
    $body = "\t<body>";
    $body .= "\n\t\t".$content;
    $body .= "\n\t</body>";
    $body .= "\n</html>";
    return $body;
}
?>