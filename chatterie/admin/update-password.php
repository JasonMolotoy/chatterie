<!-- PAGE POUR CHANGER LE MOT DE PASSE D'UN ADMINISTRATEUR -->
<?php include('partials/menu.php')?>

<div class="main-content">
  <div class="wrapper">
    <h1>Changer le mot de passe</h1>
    <br/><br/>

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
        }else{                                      //Redirige si ?id=XXX
          header('location:'.SITEURL.'admin/manage-admin.php'); 
        }
      }
    
    ?>

    <form action="" method="POST">
      <table class="tbl-30">

        <tr>
          <td>Ancien mdp:</td>
          <td>
            <input type="password" name="current_password" placeholder="Entrez le mdp actuel">
          </td>
        </tr>

        <tr>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td>Nouveau mdp:</td>
          <td>
            <input type="password" name="new_password" placeholder="Entrez le nouveau mdp">
          </td>
        </tr>
        <tr>
          <td>Réencodez le:</td>
          <td>
            <input type="password" name="confirm_password" placeholder="Confirmez le nouveau mdp">
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type='hidden' name='id' value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Changer le mot de passe" class="btn-secondary">
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
    $current_password = mysqli_real_escape_string($conn,  md5($_POST["current_password"])); //encryption md5
    $new_password = mysqli_real_escape_string($conn,  md5($_POST["new_password"]));
    $confirm_password = mysqli_real_escape_string($conn,  md5($_POST["confirm_password"]));

    //SQL Query pour sauvegarder dans la base de données
    $sql = "SELECT * FROM grL_Admin WHERE id='$id' AND password='$current_password'";
    $res = mysqli_query($conn, $sql);
    if($res==TRUE){
      $count=mysqli_num_rows($res);
      if($count==1){
        if($new_password==$confirm_password){
          $sql2 = "UPDATE grL_Admin SET password = '$new_password' WHERE id=$id";
          $_SESSION['user-not-found'] = '<div class="success">Mot de passe bien modifié.</div>';
          header("location:".SITEURL.'admin/manage-admin.php');          
        } else {
          echo "Le nouveau mot de passe ne correspond pas.";
        }
      } else{
        $_SESSION['user-not-found'] = '<div class="error">Cet admin n\'a pas été trouvé.</div>';
        header("location:".SITEURL.'admin/manage-admin.php');
      }
    }
  }
?>

<?php include('partials/footer.php')?>
