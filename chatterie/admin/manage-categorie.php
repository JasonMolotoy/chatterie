<!-- CODE POUR QUE L ADMIN PUISSE VOIR ET GERER LES CATEGORIES (modifier, supprimer) -->
<?php include('partials/menu.php') ?>
	<div class="main-content">
		<div class="wrapper">
			<h1>Gérer les Catégories</h1><br/><br/>

			<?php //Zone de message de notification selon ce qu'il se passe dans d'autre codes
				if(isset($_SESSION['add'])){
					echo $_SESSION['add'];		//Display
					unset($_SESSION['add']);	//Remove
				}
				if(isset($_SESSION['remove'])){
					echo $_SESSION['remove'];		//Display
					unset($_SESSION['remove']);	//Remove
				}
				if(isset($_SESSION['update'])){
					echo $_SESSION['update'];		//Display
					unset($_SESSION['update']);	//Remove
				}
			?>
			<br/>

			<a href="<?php echo SITEURL ; ?>admin/add-categorie.php" class="btn-primary">Ajouter une catégorie</a>
			<br/><br/><br/>
			
			<!-- Zone d'affichage en format tableau -->
			<table class="tbl-full">
				<tr>
					<th>N°</th>
					<th>Nom</th>
					<th>Image</th>
					<th>A l'accueil</th>
					<th>Visible</th>
					<th>Actions</th>
				</tr>

				<?php
					$sql="SELECT * FROM grL_Categorie";
					$res = mysqli_query($conn, $sql);
					$count = mysqli_num_rows($res);
					$sn=1; //variable pour ajuster le num de l'admin à l'affichage

					if($count>0){
						while($row=mysqli_fetch_assoc($res)){
							$id = $row['id'];
							$nom = $row['nom'];
							$nom_image = $row['nom_image'];
							$featured = $row['featured'] ? 'Oui' : 'Non';
							$active = $row['active'] ? 'Oui' : 'Non';

?>
							<tr>
								<td><?php echo $sn++; ?></td>
								<td><?php echo $nom; ?></td>
								<td>
									<?php 
										if($nom_image!=""){
											?>
											<img src="<?php echo SITEURL; ?>images/categories/<?php echo $nom_image; ?>" width="100px">
											<?php
										}else{
											echo "<div class='error'>Pas d'image ajoutée.</div>";
										}
									?>
								</td>
								<td><?php echo $featured; ?></td>
								<td><?php echo $active; ?></td>
								<td>
									<a href="<?php echo SITEURL; ?>admin/update-categorie.php?id=<?php echo $id; ?>" class="btn-secondary">Modifier</a>
									<a href="<?php echo SITEURL; ?>admin/delete-categorie.php?id=<?php echo $id; ?>&nom_image=<?php echo $nom_image; ?>" class="btn-danger">Supprimer</a>
								</td>
							</tr>

<?php
						}
					} else {
?>
						<tr>
							<td colspan='6'><div class="error">Pas de catégories ajoutées.</div></td>
						</tr>
<?php
					}
?>
			</table>
		</div>
	</div>
<?php include('partials/footer.php')?>