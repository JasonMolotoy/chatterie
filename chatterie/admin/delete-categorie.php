<!-- CODE QUI SUPPRIME LA CATEGORIE VOULU, AFFICHE JUSTE UNE NOTIF A LA PAGE DE GESTION -->
<?php 
  include('../config/constants.php');
  
  $id = $_GET['id'];
  $nom_image = $_GET['nom_image'];
  if(isset($id) AND isset($nom_image)){
    if($nom_image != ""&& file_exists("../images/categories/".$nom_image)){
      $path = "../images/categories/".$nom_image;
      $remove = unlink($path);
      if($remove==false){
        $_SESSION['remove'] = "<div class='error'>Echec de la suppression d'image pour cette catégorie.</div>";
        die();
      }
    }

    $sql = "DELETE FROM grL_Categorie WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    if($res==true){
      $_SESSION['remove'] = "<div class='success'>La catégorie a bien été supprimée.</div>";
    } else {
      $_SESSION['remove'] = "<div class='error'>Impossible de supprimer cette catégorie.</div>";
    }
  } else {
    $_SESSION['remove'] = "<div class='success'>Accès non autorisé.</div>";
  }
  header('location:'.SITEURL.'admin/manage-categorie.php');
?>