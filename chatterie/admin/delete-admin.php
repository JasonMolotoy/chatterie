<!-- CODE QUI SUPPRIME L ADMIN VOULU, AFFICHE JUSTE UNE NOTIF A LA PAGE DE GESTION -->
<?php
  include('../config/constants.php');

  //Obtient l'id et l'utilise pour supprimer dans la DB avec SQL Query
  $id= $_GET['id'];
  $sql = "DELETE FROM grL_Admin WHERE id=$id";

  //Redirige à la page de gestion, avec un message informant du déroulé
  $res = mysqli_query($conn, $sql);
  if($res==true){
    $_SESSION['delete'] = "<div class='success'>L'admin a bien été supprimé.</div>";
  } else {
    $_SESSION['delete'] = "<div class='error'>Impossible de supprimer cet admin.</div>";
  }
  header('location:'.SITEURL.'admin/manage-admin.php');
?>