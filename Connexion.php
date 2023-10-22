
<!--------------------------- Connexion a son compt --------------------------------------------->
<?php 
 session_start();

if(isset($_POST["nom2"]) && isset($_POST["motDePasse2"])){

    $nom2=$_POST["nom2"];
    $motDePasse2 =$_POST["motDePasse2"];
    

    if(empty($nom2)or empty($motDePasse2)){

        echo 'veillez renseigner les champs';//quant les variables sont vides

    }elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/", $nom2)) {

        echo "Le nom doit contenir uniquement des lettres alphabétiques.";

    }elseif(!preg_match("/^[A-Za-z0-9.-]+$/",$motDePasse2) &&  strlen($motDePasse2)<8){

        echo "inserer un mot de passe valide";

    }else{
            //Connection a la base de donnee et table
            try{
                //on se connecte a mysql

                $db = new PDO('mysql:host=localhost;dbname=db_inscriptions;charset=utf8','root','');

            }catch( Exception $e){

                    //En cas d'errreur, on affiche un message et on arrete tout
                    die('Erreur:'.$e->getMessage());
                   

            }
        }
  


        if (isset($_POST["connexion"])){ 

            $nom2=$_POST["nom2"];
            $motDePasse2 =$_POST["motDePasse2"];

            $query = "SELECT * FROM inscriptions WHERE nom = :nom";
            
            $stmt = $db->prepare($query);
            $stmt->bindValue(':nom',$nom2);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
                // Vérification du mot de passe
            if ($result && $motDePasse2 === $result['motDePasse']) {
                // echo 'Connexion réussie.';
               
                $_SESSION['nom2']= $nom2;

                    
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();

                

                  






            } else {
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        

        }      


session_destroy();
          
}
?>


<!-- ---------------------------fichier html--------------------------------------- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestion Des Taches</title>
</head>
<body>
    <div class="bloc2">

        <div class="entete">
            <h1>Gestion Des Taches</h1>
            <?php
                      
                       
                        if (isset($_SESSION['nom2']) && $_SESSION['nom2']!= '') {
            echo '<h5><i>'.$_SESSION['nom2'].'</i></h5>';
                     }
            ?> 
        </div>


        <!-- <div  class="gestion"> -->
            <?php
                // Démarrer la session pour conserver l'historique des tâches
                                         
                        // Vérifier si le formulaire a été soumis
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Récupérer les données du formulaire
                            $titre = $_POST['titre'];
                            $priorite = $_POST['priorite'];
                            $statut = $_POST['statut'];
                            $description = $_POST['description'];
                            
    
                            // Créer une nouvelle tâche en utilisant un tableau associatif
                            $nouvelleTache = array(
                                        'titre' => $titre,
                                        'priorite' => $priorite,
                                        'statut' => $statut,
                                        'description' => $description
                            );
    
                            // Ajouter la nouvelle tâche à l'historique des tâches
                            if (!isset($_SESSION['historique_taches'])) {
                                    $_SESSION['historique_taches'] = array();
                            }
                                                
                            $_SESSION['historique_taches'][] = $nouvelleTache ;
                            
                            }

            // Afficher l'historique des tâches

            if (isset($_SESSION['historique_taches']) && !empty($_SESSION['historique_taches'])) {
                                            
                foreach ($_SESSION['historique_taches'] as $tache) {

        echo' <div  class="gestion">';   
                     
                    echo' <h2>'.htmlspecialchars($tache['titre']) .'</h2>
                    <p>'.htmlspecialchars($tache['description']).'</p>
                    <div class="ges_tache">
                        <p class="P1">Priorité:'.htmlspecialchars($tache['priorite']) .'</p>
                        <p class="P2">Statut:'.htmlspecialchars($tache['statut']).'</p>
                        <input type="submit"  name="voir" value="Voir les details">
                    </div>';
        echo'</div> ';
                }
            }   
            
            ?>
           

        <!-- </div> -->








        <div class="form-ajout">
            <h2>Ajout d'une liste de tâche</h2>
        <form action="#" class="formulaire3" method="post">
            <label for="">Titre</label><br>
            <input type="text" name="titre"><br>

            <label for="">Priorité:</label><br>
            <select name="priorite" id="">
                <option value="basse">Basse</option>
                <option value="moyenne">Moyenne </option>
                <option value="haute">Haute </option>
            </select><br>

            <label for="">Statut:</label><br>
            <select name="statut" id="">
                <option value="encours">En cours</option>
                <option value="enattente">En attente</option>
                <option value="termine">Terminée </option>
            </select><br>

            <label for="">Description:</label><br>
            <textarea name="description"  cols="" rows=""></textarea><br>

            <input type="submit" value="Ajouter" class="bouton3">
        </form>
        </div>


    </div>
    
</body>
</html>



