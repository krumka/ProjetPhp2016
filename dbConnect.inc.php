<?php 
if ( count( get_included_files() ) == 1) die( '--access denied--' );

define('___MATRICULE___','HE201254');

if(stripos($_SERVER['PHP_SELF'],___MATRICULE___)==FALSE) {
	trigger_error("TENTATIVE DE FRAUDE de {$_SERVER['PHP_SELF']} chez ".___MATRICULE___, E_USER_ERROR);
	exit;
} 
else{
	$__INFOS__ = array(   'matricule'=> ___MATRICULE___
					,'host' => 'localhost'
					,'user' => 'LAMBINET'
					,'pswd' => 'RemyY3e2'
					,'dbName' => '1516he201254'
					,'nom' => 'LAMBINET'
					,'prenom' => 'R�my'  
					,'classe' => '2TL2'  
					);
}

?>