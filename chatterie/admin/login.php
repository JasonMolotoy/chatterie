<!-- PAGE OBLIGATOIRE POUR SE CONNECTER POUR AVOIR ACCES AU MENU ADMIN -->
<?php include('../config/constants.php') ?>

<html>
  <head>
    <title>Connexion - Chatterie Maine Coon</title>
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <br/><br/>

  <body>
    <div class="login">
      <h1 class="text-center">Connexion</h1>
      <form action="" method="POST" class="text-center">
        <br/>
        Nom d'utilisateur: <br/>
        <input type="text" name="username" placeholder="Entrez votre pseudo"> <br/><br/>
        Mot de passe: <br/>
        <input type="password" name="password" placeholder="Entrez votre mot de passe"> <br/><br/>
        <input type="submit" name="submit" value="Login" class="btn-primary">
        <br/><br/>
      </form>

      <?php
					if(isset($_SESSION['login'])){
						echo $_SESSION['login'];		//Display
						unset($_SESSION['login']);	//Remove
					}
      ?>
      <br/>

      <p class="text-center">Toute tentative de <a href="https://www.belgium.be/fr/justice/securite/criminalite/criminalite_informatique/hacking">hacking</a> sera poursuivie.</p>
    </div>
  </body>
</html>

<?php //Bouton login
  if(isset($_POST['submit'])){ //protection sql injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $sql = "SELECT * FROM grL_Admin WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);
    if($count==1){
      $_SESSION['login'] = "<div class='success'>Connexion réussie.</div>";
      $_SESSION['user'] = $username;
      header("location:".SITEURL.'admin/');        
    } else {
      $_SESSION['login'] = "<div class='error text-center'>Connexion échouée.</div>";
      header("location:".SITEURL.'admin/login.php');   
    }
  }

?>