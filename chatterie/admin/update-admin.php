<!-- PAGE POUR MODIFIER LES INFOS D UN ADMIN, MAIS PAS SON MOT DE PASSE POUR MOINS DERANGER -->
<?php include('partials/menu.php')?>

<div class="main-content">
  <div class="wrapper">
    <h1>Modifier l'administrateur</h1><br/><br/>

    <?php 
      $id=$_GET['id'];                              //Récupère l'ID de l'admin voulu
      $sql="SELECT * FROM grL_Admin where id=$id";  //Récupère les détails avec query

      $res=mysqli_query($conn,$sql);                //Exe le query
      if($res==true){                               //Vérifie l'exe query
        $count= mysqli_num_rows($res);              //Vérifie si data dispo
        if($count==1){
          $row= mysqli_fetch_assoc($res);
          $full_name= $row['full_name'];
          $username= $row['username'];
        }else{                                      //Redirige si pas ?id=XXX
          header('location:'.SITEURL.'admin/manage-admin.php'); 
        }
      }
    
    ?>

    <form action="" method="POST">
      <table class="tbl-30">
        <tr>
          <td>Nom et Prénom:</td>
          <td><input type="text" name="full_name" placeholder="Entrez le nom" value="<?php echo $full_name; ?>"></td>
        </tr>

        <tr>
          <td>Pseudo:</td>
          <td><input type="text" name="username" placeholder="Entrez le pseudo" value="<?php echo $username; ?>"></td>
        </tr>

        <tr>
          <td colspan="2">
            <input type='hidden' name='id' value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Mettre à jour l'administrateur" class="btn-secondary">
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php
  if(isset($_POST['submit'])) {
    //Récupère les infos du formulaire avec une protection injection sql
    $id = $_POST['id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    //SQL Query pour sauvegarder dans la base de données
    $sql = "UPDATE grL_Admin SET
      full_name= '$full_name',
      username= '$username'
      WHERE id='$id'
    ";

    $res = mysqli_query($conn, $sql);
    if($res==TRUE){
      $_SESSION['update']= "<div class='success'>L'admin a bien été modifié.</div>";
    } else {
      $_SESSION['update']= "<div class='error'>Erreur lors de la modification de cet admin.</div>";
    }
    header("location:".SITEURL.'admin/manage-admin.php');
  }
?>

<?php include('partials/footer.php')?>
