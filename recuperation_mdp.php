<?php
$file = fopen('users.csv', 'r'); // Récupération de mon tableau // Pour enlever la ligne d'entete;
    while (!feof($file) ) { // boucle pour lire tout le tableau = !feof=jusqu'à la fin du fichier
        $csv[]=fgetcsv($file, 1024, ";"); //copie des lignes de users.csv dans $csv[]
     }
     fclose($file); //fermer le fichier 

//variable boléenne 
$verify=false;

if (isset ($_POST)){
    //si les variables globales $_GET existent
    if(isset($_GET['reset_token']) AND $_GET['reset_token']){
        //boucle
        for($i=0;$i<count($csv);$i++){
            //vérification des correspondances avec le hashage des variables et du token
            if(password_verify($csv[$i][1]." ".$csv[$i][0]." ".$csv[$i][2],$_GET['reset_token'])==true){
                $verify=true;
                if ($_POST){
                    //si les variables pour le mot de passe et le nouveau mot de passe existent
                    if (isset($_POST['MDP']) AND $_POST["MDP"] AND isset($_POST['confirm_MDP']) AND $_POST['confirm_MDP']){
                        //si le mot de passe correspond à sa confirmation
                        if ($_POST['MDP']==$_POST['confirm_MDP']){
                            //stockage du mot de passe dans le tableau + hashage en méthode chiffrement ARGON2I
                            $csv[$i][3]=password_hash($_POST['MDP'], PASSWORD_ARGON2I);
                            //Appel de la fonction savefile pour écriture de ligne, ici le mot de passe
                            saveFile('users.csv',$csv);
                            $message="Le mot de passe a bien été modifié, vous allez être rédirigé automatiquement vers la page de connexion ou merci de vous connecter ici : <a href='http://localhost/Formulaire/form.php'>Se connecter</a>";
                            header("refresh:5;location:form.php");
                            }
                        else{
                            $message="le mot de passe et sa confirmation doivent être identiques";
                        }
                    }
                }
                else{
                    $message="Vous devez saisir un mot de passe et une cnfirmation de mot de passe";
                }
                
            }
        }
    }
}


//Fonction d'écriture sur un fichier
function saveFile($filename,$datas) {
    $fp=fopen($filename,'w');
    foreach($datas as $value) {

        fwrite($fp,implode(";",$value)."\r\n");
    }
    fclose($fp);
    return true;
}

?>
<?php
//vérification des correspondances avec le hashage des variables et du token si OK > la variable est vrai > alors afficher le formulaire de demande de nouveau mot de passe
 if ($verify) {?>
<!DOCTYPE html>
    
<form method="POST" action="">
<p>Formulaire de connexion/Mot de passe perdu</p>
<br>
<p>Veuillez saisir votre nouveau mot de passe</p>
<br>
<label for="caseMDP">Nouveau mot de passe :</label>
<input type="text" name="MDP">
<label for="caseMDP">Confirmer le nouveau mot de passe :</label>
<input type="text" name="confirm_MDP">

<br>
<input type="submit" name='' value="enregister">
</form>
<?php } 
else {
    print "accès interdit";
}
?>

