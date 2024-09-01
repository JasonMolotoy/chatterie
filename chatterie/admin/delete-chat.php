<!-- CODE QUI SUPPRIME LE CHAT VOULU, AFFICHE JUSTE UNE NOTIF A LA PAGE DE GESTION -->
<?php 
  include('../config/constants.php');
  
  $id = $_GET['id'];
  $nom_image = $_GET['nom_image'];
  if(isset($id) AND isset($nom_image)){
    if($nom_image != ""&& file_exists("../images/chats/".$nom_image)){
      $path = "../images/chats/".$nom_image;
      $remove = unlink($path);
      if($remove==false){
        $_SESSION['remove'] = "<div class='error'>Echec de la suppression d'image pour ce chat.</div>";
        die();
      }
    }

    $sql = "DELETE FROM grL_Chat WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    if($res==true){
      $_SESSION['remove'] = "<div class='success'>Le chat a bien été supprimé.</div>";
    } else {
      $_SESSION['remove'] = "<div class='error'>Impossible de supprimer ce chat.</div>";
    }
  } else {
    $_SESSION['remove'] = "<div class='success'>Accès non autorisé.</div>";
  }
  header('location:'.SITEURL.'admin/manage-chat.php');
?>