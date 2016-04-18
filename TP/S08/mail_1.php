<?php
//adresse email
$mail = "rem.lambi171@gmail.com";

//Filtrage des Bugs de passage de lignes
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
    $passage_ligne = "\r\n";
} else{
    $passage_ligne = "\n";
}

//Message
$msg = "<html><head></head><body><p><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</p><p>Deuxieme ligne.</p><p>Venant de <a href='http://193.190.65.94/HE201254/TP/S08/'>cette</a> Page. </p></body></html>";

//Sujet
$subject = "Test de mail en Php";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

//Header of the mail
$header  = 'MIME-Version: 1.0' . $passage_ligne;
$header .= 'Content-type: text/html; charset=iso-8859-1' . $passage_ligne;
$header .= "From: \"Serveur Ephec\"<rem.lambi171@gmail.com>".$passage_ligne;
$header.= "Reply-to: \"Rémy Lambinet\" <rem.lambi171@gmail.com>".$passage_ligne;

// send email
if(mail($mail,$subject,$msg, $header)){
    echo "Message Envoyé";
}
?>