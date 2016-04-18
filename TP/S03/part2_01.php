<?php
    require "phpFunctions/myFunctions.inc.php";
    require "layout.php";
    include "../dbConnectMiniCampus.php";

    $layout = new layout();
    $layout->title = "Sem03p2";
    $layout->linkCss = array("./css/Sem03p2.css");
    $layout->body = today(0).today(1);

    $form = new Form("part2_01.php", null, "f", "f", null, "Valider");
    $form->addLegend("Recherche des cours du groupe");
    $form->addItem("text", "gr", "groupe", "", null, null, null, null, "Groupe à rechercher", null, true, true, null, null);
    $layout->body .= $form->html();
    array_push($layout->linkCss, $form->css);

    if(isset($_GET['groupe'])) {
        $groupe = $_GET['groupe'];
        $sql = "SELECT code, faculte, intitule FROM cours
                INNER JOIN course_class ON cours.code=course_class.cours_id
                INNER JOIN class ON course_class.class_id=class.id
                WHERE class.nom=\"" . $groupe . "\"
                ORDER BY code;";
        $listTab[0] = array("Code", "Faculté", "Intitulé");
        $answer = $world->query($sql);//requète
        $res = $answer->fetchAll();
        if (count($res) == 0){
            $layout->body .= "<p id='error'>Le groupe n'existe pas</p>";
        }else{
            foreach($res as $datas){
                array_push($listTab, array($datas['code'], $datas['faculte'], $datas['intitule']));
            };
            $answer->closeCursor();
            $tab = new Tableau($listTab, "Cours pour le groupe " . $groupe, true, 3);
            $layout->body .= $tab->html();
            $layout->addCss($tab->getCss());
        }
        $answer->closeCursor();
    }
    $layout->display();
?>