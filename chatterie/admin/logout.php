<!-- CODE POUR SE DECONNECTER, N AFFICHE RIEN -->
<?php
  include('../config/constants.php');
  session_destroy();
  header('location:'.SITEURL.'admin/login.php');
?>