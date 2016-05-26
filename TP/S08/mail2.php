<?php
require "layout.php";

$form = new Form("mail2.php", "post", "f", "f", "", "Envoyer");
$form->addItem("email", "mail", "mail", "To : ", 50, 5 , 1, 30, "E-mail du destinataire", null, true, true, null, null);
$form->addItem("text", "sjt", "sjt", "Sujet : ", 50, 1, 1, 30, "Sujet du mail", null, true, null, null, null);
$form->addTxtArea("msg", 50, 10, "Le texte de votre Mail.", null, true, null, null);
$form->addTxt("</br>");
echo $form->html();

//adresse email
if(isset($_POST['mail'])){
    $mail = $_POST['mail'];
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
        $passage_ligne = "\r\n";
    } else{
        $passage_ligne = "\n";
    }
    //Header of the mail
    $header  = 'MIME-Version: 1.0' . $passage_ligne;
    $header .= 'Content-type: text/plain; charset=iso-8859-1' . $passage_ligne;
    $header .= "From: \"Serveur Ephec\"<rem.lambi171@gmail.com>".$passage_ligne;
    $header.= "Reply-to: \"Rémy Lambinet\" <rem.lambi171@gmail.com>".$passage_ligne;
    $header .= "X-Mailer: PHP/" . phpversion();
}

//Message
if(isset($_POST['msg'])){
    $msg = $_POST['msg'];
    $msg .= $passage_ligne.$passage_ligne.strtolower(dirname($_SERVER['SERVER_PROTOCOL'])) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

//Sujet
if(isset($_POST['sjt'])){
    $subject = $_POST['sjt'];
    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
}

// send email
if(isset($_POST['mail']) and isset($_POST['msg']) and isset($_POST['sjt'])){
    if(mail($mail,$subject,$msg, $header)){
        echo "Message Envoyé";
    }
}
?>