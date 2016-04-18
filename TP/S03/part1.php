<?php
    require "phpFunctions/myFunctions.inc.php";
    require "layout.php";

    $layout = new layout();
    $layout->title = "Sem03p1_01";
    $layout->linkCss = "./css/Sem03p1_01.css";
    $layout->body = today(0).today(1);

    $layout->display();
?>