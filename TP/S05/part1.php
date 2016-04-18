<?php
    session_start();
    require "phpFunctions/myFunctions.inc.php";
    require "layout.php";
    include "../dbConnectMiniCampus.php";

    //création du layout de base
    $layout = new layout();
    $layout->title = "Sem04p1";
    $layout->linkCss = array("./css/Sem04p1.css");
    $layout->body = today(0).today(1);

    //création du tableau pour la première liste
    $sqlSct = "select id, nom from class where parent_id is null";
    $answer = $world->query($sqlSct);
    $sct[0] = array(-1, "-- Section --");
    while ($datas = $answer->fetch()) {
        array_push($sct, array($datas['id'], $datas['nom']));
    }
    $answer->closeCursor();
    //création du formulaire
    $form = new Form("part1.php", "GET", "f", "f", null, null);
    $form->addLegend("Formulaire de recherche");
    array_push($layout->linkCss, $form->css);
    if(!(isset($_GET['sct'])&&$_GET['sct']!=-1)){
        $form->addList("section\" class=\"nobr\"","sct", $sct, "this.form.submit();", null);
        $_SESSION[-1]['list'] = $form->elementsTab[0];
    }else{
        $form->addList("section\" class=\"nobr\"","sct", $sct, "this.form.submit();", $_GET['sct']);
        $sqlAnSec = "select id, nom from class where parent_id =".$_GET['sct'];
        $answer = $world->query($sqlAnSec);
        $anSec[0] = array(-1, "-- Année --");
        while($datas = $answer->fetch()){
            array_push($anSec, array($datas['id'], $datas['nom']));
            if(isset($_GET['anSec']))if($_GET['anSec']==$datas['id'])$doGrp = true;
        }
        $answer->closeCursor();
        if(!(isset($_GET['anSec'])&&$_GET['anSec']!=-1)){
            $form->addList("anSct\" class=\"nobr\"","anSec", $anSec, "this.form.submit();", null);
        }else{
            $form->addList("anSct\" class=\"nobr\"","anSec", $anSec, "this.form.submit();", $_GET['anSec']);
            if(isset($doGrp)){
                $sqlGrp = "select id, nom from class where parent_id =".$_GET['anSec'];
                $answer = $world->query($sqlGrp);
                $grp[0] = array(-1, "-- Groupe --");
                while($datas = $answer->fetch()){
                    array_push($grp, array($datas['id'], $datas['nom']));
                    if(isset($_GET['grp']))if($_GET['grp']==$datas['id'])$doCla = true;
                }
                $answer->closeCursor();
                if(!(isset($_GET['grp'])&&$_GET['grp']!=-1)){
                    $form->addList("group\" class=\"nobr\"","grp", $grp, "this.form.submit();", null);
                }else {
                    $form->addList("group\" class=\"nobr\"", "grp", $grp, "this.form.submit();", $_GET['grp']);
                    if (isset($doCla)) {
                        $sqlCla = "select id, nom from class where parent_id =".$_GET['grp'];
                        $answer = $world->query($sqlCla);
                        $cla[0] = array(-1, "-- Classe --");
                        while($datas = $answer->fetch()){
                            array_push($cla, array($datas['id'], $datas['nom']));
                            if(isset($_GET['cla']))if($_GET['cla']==$datas['id'])$doTab = true;
                        }
                        $answer->closeCursor();
                        if(!(isset($_GET['cla'])&&$_GET['cla']!=-1)){
                            $form->addList("class\" class=\"nobr\"","cla", $cla, "this.form.submit();", null);
                        }else {
                            $form->addList("class\" class=\"nobr\"", "cla", $cla, "this.form.submit();", $_GET['cla']);
                        }
                    }
                }
            }
        }
    }
    $layout->body .= $form->html();
    //dernière requète affichant le tableau
    if(isset($doTab)) {
        $sql = "SELECT code, faculte, intitule FROM cours
                    INNER JOIN course_class ON cours.code=course_class.cours_id
                    INNER JOIN class ON course_class.class_id=class.id
                    WHERE class.id=\"" . $_GET['cla'] . "\"
                    ORDER BY code;";
        $listTab[0] = array("Code", "Faculté", "Intitulé");
        $answer = $world->query($sql);//requète

        while($datas = $answer->fetch()){
            array_push($listTab, array($datas['code'], $datas['faculte'], $datas['intitule']));
        };
        $answer->closeCursor();
        $tab = new Tableau($listTab, "Cours pour le groupe " . $_GET['cla'], true, 3);
        $layout->body .= $tab->html();
        $layout->addCss($tab->getCss());
        $answer->closeCursor();
    }
    //inclusion du formulaire dans l'html et affichage
    $layout->display();
    print_r($_SESSION);
?>