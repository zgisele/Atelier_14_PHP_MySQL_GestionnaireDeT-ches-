<?php
// ------------------------------------------Creation de compte----------------------------------------------
if(isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["motDePasse"]) && isset($_POST["Confirmation"])){
    
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $motDePasse = $_POST["motDePasse"];
    $Confirmation = $_POST["Confirmation"];

    if(empty($nom) or empty($email) or empty($motDePasse) or empty( $Confirmation)){

        echo 'veillez renseigner les champs';//quant les variables sont vides

    }elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/", $nom)) {

        echo "Le nom doit contenir uniquement des lettres alphabétiques.";
    
    }elseif (!preg_match("/^[a-zA-Z]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)){

        echo "L'adresse e-mail n'est valide.";

    } elseif(!preg_match("/^[A-Za-z0-9.-]+$/", $motDePasse ) &&  strlen($motDePasse)<8){

        echo "inserer un mot de passe valide";

    } elseif($motDePasse!= $Confirmation){

        echo "La confirmation du mot de passe est incorrect";

    }
    else{
            //Connection a la base de donnee et table
            try{
                //on se connecte a mysql

                $db = new PDO('mysql:host=localhost;dbname=db_inscriptions;charset=utf8','root','');

            }catch( Exception $e){

                    //En cas d'errreur, on affiche un message et on arrete tout
                    die('Erreur:'.$e->getMessage());
                    // ' Une erreure est survenue lors de la connection'

            }

            $sqlQuery ="INSERT INTO inscriptions(nom,email,motDePasse) VALUES ('".$nom."','". $email."','".$motDePasse."')";

            $reponse = $db->exec($sqlQuery);//execution de la requete


            if ($reponse==0) {
                echo 'Rien n\'est insérer' ;// Le resultat si l'execution n'a pas fonctionner
            }else{
                echo'<h2> Votre compte a bien ete crée !  </h2><br>'.$nom;// Le resultat si l'execution a pas fonctionner
                
            }
         
    }


}else{
    echo 'Un des champs n\'existe pas'; //quant un des champs du formulaire n'exite pas.
}


echo'<br><br><br><br><br><a href="Connexion.html" style=" font-size: 16px ; text-align: center ; padding-bottom: 20px ; padding-left: 20px ; padding-right:20px ; color: aliceblue ; background-color: rgb(76, 175, 80) ; border-radius: 5px ;border:none;">Retour a la page connexion </a><br>'

?>


