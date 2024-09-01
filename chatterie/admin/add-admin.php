<!-- PAGE POUR AJOUTER UN ADMIN DANS LA BASE DE DONNEES, EN ETANT ADMIN -->
<?php include('partials/menu.php'); ?>

  <div class="main-content">
    <div class="wrapper">
      <h1>Ajouter un administrateur</h1><br/><br/>

      <?php
        if(isset($_SESSION['add'])){
          echo $_SESSION['add'];
          unset ($_SESSION['add']);
        }
      ?>

      <form action="" method="POST">
        <table class="tbl-30">
          <tr>
            <td>Nom et Prénom:</td>
            <td>
              <input type="text" name="full_name" placeholder="Ex: Foucart Sabrina">
            </td>
          </tr>

          <tr>
            <td>Nom de connexion:</td>
            <td>
              <input type="text" name="username" placeholder="Ex: SabChatterie">
            </td>
          </tr>

          <tr>
            <td>Mot de passe:</td>
            <td>
              <input type="password" name="password" placeholder="Ex: mdp9Resist@nt">
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
            </td>
          </tr>
        </table>
      </form>

    </div>
  </div>

<?php include('partials/footer.php'); ?>


<?php
  $conn = mysqli_connect('localhost', 'root', '', 'grL_Chatterie') or die(mysqli_error($conn));

  if(isset($_POST['submit'])) {
    //Récupère les infos du formulaire avec protection injection sql
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn,  md5($_POST["password"])); //encryption md5

    $sql = "INSERT INTO grL_Admin SET
      full_name= '$full_name',
      username= '$username',
      password= '$password'
    ";

    //Test de réussite d'enregistrement
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if($res==TRUE){
      $_SESSION['add']= "<div class='success'>L'admin a bien été ajouté.</div>";
      header("location:".SITEURL.'admin/manage-admin.php');
    } else {
      $_SESSION['add']= "<div class='error'>Erreur lors de l'ajout de cet admin.</div>";
      header("location:".SITEURL.'admin/add-admin.php');
    }
  }
?>