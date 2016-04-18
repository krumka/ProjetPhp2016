<?php
require "layout.php";
require "nav.inc.php";
$layout = new Layout();
$layout->title = "Demo Sessions";
$layout->body = nav(null);
$layout->linkCss = array("css/demoSession.css");
$layout->display();