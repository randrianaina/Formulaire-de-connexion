<?php
//FORMULAIRE DE CONNEXION - COURS PHP - Jérôme LESAINT - AFPA - 09/07/2020


//INITIALISATION DE LA SESSION
session_start();

//Récupération des données du fichier users.csv sans les en-têtes
//OUVERTURE LECTURE DU FICHIER CSV - STOCKAGE DES DONNEES DANS UN NOUVEAU TABLEAU
$file = fopen('users.csv', 'r'); // Récupération de mon tableau // Pour enlever la ligne d'entete;
    while (!feof($file) ) { // boucle pour lire tout le tableau = !feof=jusqu'à la fin du fichier
        $csv[]=fgetcsv($file, 1024, ";"); //copie des lignes de users.csv dans $csv[]
     }
     fclose($file); //fermer le fichier 

// ATTRIBUTION DES VALEURS DE $_SESSION AUX VALEURS DE $_COOKIE SI LES COOKIES SONT ACTIFS ET ONT UNE VALEUR
if((isset($_COOKIE['name']) AND $_COOKIE['name'])AND(isset($_COOKIE['firstname']) AND $_COOKIE['firstname'])){
    for($i=0;$i<count($csv);$i++){
        if((password_verify($csv[$i][1],$_COOKIE['name'])) AND (password_verify($csv[$i][0],$_COOKIE['firstname']))){
            $_SESSION['name']=$csv[$i][1];
            $_SESSION['firstname']=$csv[$i][0];
        }
    }
    $_SESSION['name']=$_COOKIE['name'];
    $_SESSION['firstname']=$_COOKIE['firstname'];
    header('location:bienvenue.php');
}

//CONDITION SI LE BOUTON DE DECONNEXION DU FICHIER bienvenue.php EST CLIQUE
if (isset($_GET['deconnecter']) AND ($_GET['deconnecter']==true)){ 
    //suppression des valeurs de $_SESSION
    unset($_SESSION); 
    //attribution de $_COOKIE['name'] à NULL pour suppression
    setcookie('name',NULL,0); 
    //attribution de $_COOKIE['firstname'] à NULL pour suppression
    setcookie('firstname',NULL,0); 
    //fermeture de la session
    session_destroy(); 
    
}

//Comparaison de la saisie de l'utilisateur
if (isset($_POST)) {
     //si les variables existent
    if((isset($_POST['ID'])) AND ($_POST['ID']) AND (isset($_POST['PASSWORD'])) AND ($_POST['PASSWORD'])){
        //Boucle pour vérification de chaque lignes du tableau      
        for($i=0;$i<count($csv);$i++){
            //Vérification des informations saisies et du tableau $csv (email>ID, mot de passe>PASSWORD) 
            if ($_POST['ID']==$csv[$i][2] AND password_verify($_POST['PASSWORD'],$csv[$i][3])==true){  
                //lecture des informations (début)
                $_SESSION['firstname'] = $csv[$i][0];
                $_SESSION['name']   = $csv[$i][1];
                //condition si checkbox stay_connected est actif
                if(isset($_POST['stay_connected']) AND $_POST['stay_connected']){
                    //application d'un cookie avec la fonction setcookie qui stocke le nom crypté avec PASSWORD_DEFAULT avec la fonction password_hash avec une durée, ici 3600 secondes ou 1 jour
                    setcookie('name', password_hash($csv[$i][1], PASSWORD_DEFAULT),time()+86400);
                    //application d'un cookie avec la fonction setcookie qui stocke le prénom crypté avec PASSWORD_DEFAULT avec la fonction password_hash avec une durée, ici 3600 secondes ou 1 jour
                    setcookie('firstname',password_hash($csv[$i][0], PASSWORD_DEFAULT),time()+86400); 
                }
                //accès au fichier (fin / ordre à respecter!)
                header('location:bienvenue.php');  
            }
            //Si informations saisies sont incorectes
            else{
                echo 'identifiant ou mot de passe incorrect';
            }
        }
    }
}

?>
<html>
    <h1>Bienvenue</h1>
    <form method="POST" action="">
        <p>Formulaire de connexion</p>
        <br>
        <label for="caseID">Identifiant (mail) :</label>
        <input type="text" name="ID">
        <br>
        <label for="casePASSWORD">Mot de passe :</label>
        <input type="text" name="PASSWORD">
        <br>
        <label for="">Rester connecté ?</label>
        <input type="checkbox" name="stay_connected">
        <hr>
        <input type="submit" value="Connexion">
        <hr>
        <p></p>

    </form>
    <a href='mdpperdu.php'>Mot de passe perdu</a>
</html>