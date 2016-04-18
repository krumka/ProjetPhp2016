<?php
function nav($currPage){
    $nav = "<nav id=\"menu\">";
    $nav .= "<input ";
    if($currPage=="Start"){
        $nav .= "style=\"color:yellow;\" ";
    }
    $nav .= " type=\"submit\" value=\"Start\" name='page' onclick=\"location.href='demoSessionStart.php'\">";
    $nav .= "<input ";
    if($currPage=="Get01"){
        $nav .= "style=\"color:yellow;\" ";
    }
    $nav .= " type=\"submit\" value=\"Get01\" name='page' onclick=\"location.href='demoSessionGet01.php'\">";
    $nav .= "<input ";
    if($currPage=="Get02"){
        $nav .= "style=\"color:yellow;\" ";
    }
    $nav .= " type=\"submit\" value=\"Get02\" name='page' onclick=\"location.href='demoSessionGet02.php'\">";
    $nav .= "<input ";
    if($currPage=="Print_r"){
        $nav .= "style=\"color:yellow;\" ";
    }
    $nav .= " type=\"submit\" value=\"Print_r\" name='page' onclick=\"location.href='demoSessionModify.php'\">";
    $nav .= "<input ";
    if($currPage=="Destroy"){
        $nav .= "style=\"color:yellow;\" ";
    }
    $nav .= " type=\"submit\" value=\"Destroy\" name='page' onclick=\"location.href='demoSessionDestroy.php'\">";
    $nav .= "</nav>";
    $nav .= "</br>";
    return $nav;
}