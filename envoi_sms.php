<?php
// reference : http://guides.ovh.com/TelSmsSend

//entrer votre nic-handle, remplacer xx123456-ovh par votre propre nic-handle
$nic="xxxyyy-ovh";

//entrer le mot de passe de votre nic-handle, remplacer ovh123456 par votre propre mot de passe
$pass="passwd";

//entrer le nom de votre compte sms, remplacer sms-xx123456-1 par votre propre compte
$sms_compte="sms-xxxyyy-1";

/*entrer le num�ro emetteur du sms, ce num�ro doit etre identifie dans votre manager,
remplacer +33600110011 par votre propre numero de mobile*/
$from="+33021245781";
$to="+33601010101" ;

include_once ('sms_parameters.php');

/* creation de la variable to dans laquelle nous recuperons via la methode post
le champ portant le nom destinataire au niveau de la page form.html */




/* creation de la variable message dans laquelle nous recuperons via la methode post
le champ portant le nom texte au niveau de la page form.htlm */
//$message=" Coucou c'est philippe qui teste l'envoi de SMS !!! "; //$HTTP_POST_VARS['texte'];
$message="Merci de répondre au questionnaire de l'application de suivi.";

// ouverture de la fonction soapi
try
{
	// on travail en soapi
	$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.8.wsdl");
	
	/* connexion a votre manager avec vos identifiants, ici on utilise
	le compte xx123456-ovh ($nic) avec le mot de passe ovh123456 ($pass), le nic-handle est francais */
	$session = $soap->login("$nic", "$pass","fr", false);
	
	// affichage de la reponse pour la connexion
	echo "login successfull\n";

	// REQUETE POUR RECUPERER LES LIGNES D'ENVOI
	//table_device_tel : enable, deviceuid ,tel
	//time_stamp :  uid, creation, ts_debut, devideuid
	// Make a MySQL Connection
	mysql_connect($mysql_server, $mysql_user, $mysql_password ) or die(mysql_error());
	mysql_select_db($mysql_base) or die(mysql_error());
	$sql ="SELECT * FROM time_stamp as ts 
			LEFT JOIN table_device_tel as tdt 
			ON tdt.deviceuid = ts.devideuid 
			WHERE tdt.enable = 1 
			AND ts.ts_debut > NOW() 
			AND ts.ts_debut < (NOW() + INTERVAL 1 DAY)
			ORDER BY ts.ts_debut ASC";
	$resultsql = mysql_query($sql) or die(mysql_error());
	//echo $sql;

	while ($row = mysql_fetch_array($resultsql,MYSQL_ASSOC)) {
		$to =$row["tel"];
		$delaysmsmin = ceil((strtotime($row["ts_debut"]) - time()) / 60) ;
		/* on utilise ici le compte sms sms-xx123456-1 ($sms_compte) pris sur notre nic-handle xx123456-ovh,
		le numero 06600110011 ($from) a ete identifie dans notre manager on l utilise donc en tant
		qu emetteur, le desinataire se place ensuite ($to), la variable $message contient le texte du sms, le vide permet de laisser
		les parametres par defaut, le "1" force l envoi du sms au format classique,
		le sms est sauvegarde sur le portable client */
		/*$result = $soap->telephonySmsSend(connexion_au_manager, "compte_sms", "numero_de_l_expediteur", "numero_du_destinataire", 
						"message_du_sms", "temps_pour_l_envoi", "type_de_sms", "temps_avant_envoi", "priorite_du_sms");*/
		/*temps_avant_envoi : en minutes !!!*/
		//$result = $soap->telephonySmsSend($session, "$sms_compte", "$from", "$to", "$message", "", "1", "$delaysmsmin", "");
		//echo "<br/>to:".$to."<br/>delai en minutes:".$delaysmsmin."<br/>";
		
		// affichage de l etat
		echo "telephonySmsSend successfull\n";
		
		// affichage du resultat
		//print_r($result);
		/*echo "<pre>";
		print_r($row);
		echo "</pre>";*/

		// on ferme la connexion au manager
		$soap->logout($session);
		// affichage de la reponse de fermeture de connexion
		echo "logout successfull\n";
	}//boucle while sur resultat mysql
	mysql_free_result($result);
	
}/*fin try*/

catch(SoapFault $fault)
{
// affichage des erreurs
echo $fault;
}

// fermeture de la balise php

?>