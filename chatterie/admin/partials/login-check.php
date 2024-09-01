<!-- CODE POUR VERIFIER LA CONNECTION, N AFFICHE RIEN -->
<?php
  if(!isset($_SESSION['user'])){  //user not set
    $_SESSION['login'] = "<div class='error text-center'>Veuillez vous connecter.</div>";
    header("location:".SITEURL.'admin/login.php');   
  }
?>