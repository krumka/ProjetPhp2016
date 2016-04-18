<!DOCTYPE HTML>
<html>
    <head>
        <style>
            #date{
                color : yellow;
                background-color : red;
                padding : 15px;
            }
            #hour{
                color: red;
                background-color: yellow;
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <?php
        $date = date("d-m-Y");
        $hour = date("H:i");
        echo "<span id=date>".$date."</span>";
        echo "<span id=hour>".$hour."</span>";
        ?>
    </body>
</html>
