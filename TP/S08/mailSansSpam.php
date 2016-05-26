<?php
    $pseudo= 'Remy';

    $message = '
        <html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1 style="margin:auto; text-align:center">Félicitation '. $pseudo .'</h1>
		<p>
			Vous êtes désormais inscrit sur le super forum de PMM!<br/><br\>
			A partir de maintenant, vous pourrez accédez à tout un tas de sujet que modérateurs<br/>
			et utilisateurs échangent entre eux, et désormais... avec vous !<br\>
			N\'hésitez surtout pas à revenir régulièrement car ça va bougez ici ! 
		</p>
	</body>
</html>';
           
    $message = wordwrap($message, 70, "\r\n");
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $headers .= "From: no-reply@forum-pmm.be" . "\r\n" .
    "Reply-To: no-reply@forum-pmm.be" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

     mail('', 'Bienvenue !', $message, $headers);



?>
