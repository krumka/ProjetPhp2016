<?php
$configTab=parse_ini_file("config.ini.php", true);
?>
<form method="post" action="writeConfig.php">
    <?php foreach($configTab as $key1 => $value1){
        if($key1!="erreur") {
            echo "<fieldset>
                  <legend>" . $key1 . "</legend>";
            foreach ($value1 as $key2 => $value2) {
                if (is_array($value2)) {
                    if ($key2 != "choix") {
                        echo "<p style='text-transform : capitalize;'>" . $key2 . " : ";
                        /*echo "<p><label for='" . $key2 . "' style='text-transform : capitalize;'>" . $key2 . " : </label><select id='" . $key2 . "'>";
                        echo "<option>-- Choisissez --</option>";
                        foreach ($value2 as $key3 => $value3) {
                            echo "<option value='" . $value3 . "'>" . $value3 . "</option>";
                        }
                        echo "</select></p>";*/
                        foreach ($value2 as $value3) {
                            echo "<input type='checkbox' name='" . $value3 . "' id='" . $value3 . "' style='margin-left : 10px;'><label for='" . $value3 . "'>" . $value3 . "</label>";
                        }
                        echo "</p>";
                    } else {
                        foreach ($value2 as $value3) {
                            echo "<script> document.getElementById('" . $value3 . "').checked = true; </script>";
                        }
                    }
                } else {
                    if (is_numeric($value2)) {
                        if ($key2 != "min" && $key2 != "max") {
                            echo "<p><label for='" . $key2 . "' style='text-transform : capitalize;'>" . $key2 . " : </label><input type=number value='" . $value2 . "' step='1' id='" . $key1 . $key2 . "' name='" . $key1 . $key2 . "'";
                        } else if ($key2 == "min") {
                            echo " min='" . $value2 . "'";
                        } else if ($key2 == "max") {
                            echo " max='" . $value2 . "' ></p>";
                        }
                    } else {
                        echo "<p><label for='" . $key2 . "' style='text-transform : capitalize;'>" . $key2 . " : </label><input type=text value='" . $value2 . "' id='" . $key2 . "' name='" . $key2 . "'></p>";
                    }
                }
            }
            echo "</fieldset>";
        }
    }
    ?>
    <input type="submit" value="Envoyer">
</form>
<?php
echo "<pre>";
echo print_r($configTab);
echo "</pre>";