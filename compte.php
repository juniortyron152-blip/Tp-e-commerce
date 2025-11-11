<!DOCTYPE html>
<?php 

session_start();

include("bd.php");

// si l'utilisateur s'est déjà inscrit , redirigé le vers la page de son compte
   /* else{
  header("location : Compte.php");
  exit;
 }*/




if(isset($_POST["inscrire"])){

      $name = $_POST["name"];
      $Adresse_email = $_POST["email"];
      $Numéro_de_téléphone = $_POST["number"];
      $password = $_POST["password"];
      $Confirmer_mot_de_passe = $_POST["confirm-password"];

      // Si les mots de passe  ne correspondent pas 
      if($password !== $Confirmer_mot_de_passe){
        header("location: compte.php?error=Les mots de passe ne correspondent pas");
      

      // Si le mot de passe est trop court
       //}else if(strlen($Password) < 6 ){
        //header("location: Register.php?error=Le mot de passe doit avoir au moins 6 caractères"); 
  

        // Si jusqu'à là tout est correcte 
      }else{

                // Verifier si il n'existe pas des utilisateurs avec la même adresse email
              $stmt1 = $conn->prepare("SELECT count(*) FROM client WHERE email = ?");
              $stmt1->bind_param("s", $Adresse_email);
              $stmt1->execute();
              $stmt1->bind_result($num_rows);
              $stmt1->store_result();
              $stmt1->fetch();

                
                // Si Un utilisateur avec cette adresse email existe déjà
              if($num_rows !=0){
                header("location: compte.php?error=Un utilisateur avec cette adresse email existe déjà");
              


              // Si aucun  utilisateur avec cette adresse email n'existe  alors un nouvel utilisateur peut être créé
              }else{

                  // Crée  un nouvel utilisateur

                  $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                  $stmt = $conn->prepare("INSERT INTO client (nom, email,  mot_de_passe	 , téléphone)
                                        VALUES (?,?,?,?)");
                      
                  $stmt->bind_param("sssi", $name, $Adresse_email, $hashed_password, $Numéro_de_téléphone);


                  // si le compte a été créé avec succès 
                  if($stmt->execute()){

                    $user_id = $stmt->insert_id;

                    $_SESSION["ID_client"] = $user_id;
                    $_SESSION["email"] = $Adresse_email;
                    $_SESSION["nom"] = $name;
                    $_SESSION["logged-in"] = true;
                    header ("location: index.html?Register_message=Vous vous êtes incrit avec succès.");

                  }else{
                    header("location : compte.php?errow=Vous ne pouvez pas créer de compte en ce moment.");
                  }

              }
            }
      
          }
  ?>        
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JL</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="compte.css">
</head>
<body>
   <header>
   <div class="navbar">
    <nav>
        <img src="./img/03.jpg"alt="photo">
        <ul>
            <li><a href="Index.html">Accueil</a></li>
            <li><a href="bt.html">Boutique</a></li>
            <li><a href="about.html">A propos</a></li>
            <li><a href="contact.html">Contactez-nous</a></li>
        </ul>
    </nav>
        <div class="nav-item">
                <a href="panier.html"><i class="fas fa-shopping-cart"></i></a>
                <a href="Compte.html"><i class="fas fa-user"></i></a>
                
            
        </div>
   </div>
   </header> 
   <main>
    <div class="signup-form">
    <form method="POST" action="compte.php">
    <p style="color: red"><?php  if(isset($_GET['error'])){ 
        echo $_GET['error'];
        }
        ?></p>
        <label for ="email">Votre e-mail</label>
        <input type="email"id="email"name="email"placeholder="Entrez votre email">

        <label for ="name">Votre nom</label>
        <input type="text"id="name"name="name"placeholder="Entrez votre nom">
        <label for="phone">Téléphone</label>
        <input type="text"id="number"name="number"placeholder="Entrez votre numéro de téléphone">
        <label for ="password">Mot de passe</label>
        <input type="password"id="password"name="password"placeholder="Entrez votre mot de passe">

        <label for ="confirm-password">Confirmez le mot de passe</label>
        <input type="password"id="confirm-password"name="confirm-password"placeholder="Confirmez le mot de passe">
        <input type="submit"name="inscrire"value="S'inscrire">
    </form>
    <p>Vous avez déjà un compte ?<a href="login.php"> Se connecter</a></p>
</div>
   </main>
   <footer class="footer">
    <div class="mt-0 py-0">
     <h3>Jewelry Luxurious</h3>
     <p>122 Rue Deido</p>
     <p>Téléphone :+237 680344045</p>
     <p>Email : JLstore@gmail.com</p>
    </div>
    <div class="footer-bottom">
     <p>&copy; 2024 JL Store.Tous les droits réservés</p>
    </div>
    </footer>
 </body>
 </html>