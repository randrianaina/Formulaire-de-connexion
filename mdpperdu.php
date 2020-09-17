<?php

require_once("Fonction mail.php");


$file = fopen('users.csv', 'r'); // Récupération de mon tableau // Pour enlever la ligne d'entete;
    while (!feof($file) ) { // boucle pour lire tout le tableau = !feof=jusqu'à la fin du fichier
        $csv[]=fgetcsv($file, 1024, ";"); //copie des lignes de users.csv dans $csv[]
     }
     fclose($file); //fermer le fichier 

if (isset($_POST)) {
//si les variables existent
    if((isset($_POST['ID'])) AND ($_POST['ID'])){
        //Boucle pour vérification de chaque lignes du tableau      
        for($i=0;$i<count($csv);$i++){
            //Vérification des informations saisies et du tableau $csv (email>ID) 
            if ($_POST['ID']==$csv[$i][2]){
                //afichage du lien de réinitialisation du mot de passe
                print "Un lien pour réinitialiser votre mot de passe a été envoyé sur votre adresse e-mail";
                $lien="http://localhost/Formulaire/recuperation_mdp.php?reset_token=".password_hash(($csv[$i][1]." ".$csv[$i][0]." ".$csv[$i][2]), PASSWORD_DEFAULT);
                sendMail($csv[$i][2],$csv[$i][0]." ".$csv[$i][1],$lien);
            }
            else{
               echo 'Nous ne reconnaissant pas cette adresse e-mail';
            }
        }
    }
}
?>


<!DOCTYPE html>
<form method="POST">
<h1>Formulaire de connexion/Mot de passe perdu</h1>
<br>
<p>Veuillez saisir votre adresse e-mail</p>
<br>
<label for="caseID">Identifiant (mail) :</label>
<input type="text" name="ID">
<br>
<input type="submit" value="envoyer le lien">
<br>
</form>
