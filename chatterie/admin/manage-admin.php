<!-- PAGE POUR VOIR ET GERER LES ADMINISTRATEURS -->
<?php include('partials/menu.php')?>
	<div class="main-content">
		<div class="wrapper">
			<h1>Gestionnaire d'administrateur</h1><br/><br/>

			<?php		//Zone de message de notification selon ce qu'il se passe dans d'autre codes
				if(isset($_SESSION['add'])){
					echo $_SESSION['add'];		//Display
					unset($_SESSION['add']);	//Remove
				}
				if(isset($_SESSION['delete'])){
					echo $_SESSION['delete'];
					unset($_SESSION['delete']);
				}
				if(isset($_SESSION['update'])){
					echo $_SESSION['update'];
					unset($_SESSION['update']);
				}
				if(isset($_SESSION['user-not-found'])){
					echo $_SESSION['user-not-found'];
					unset($_SESSION['user-not-found']);
				}
			?>
			<br/><br/>

			<a href="add-admin.php" class="btn-primary">Ajouter un admin</a>
			<br/><br/><br/>
			
			<!-- Zone d'affichage en format tableau -->
			<table class="tbl-full">
				<tr>
					<th>N°</th>
					<th>Nom</th>
					<th>Pseudo</th>
					<th>Actions</th>
				</tr>

				<?php
					$sql = "SELECT * FROM grL_Admin";
					$res = mysqli_query($conn, $sql);
					if($res==TRUE){
						$count = mysqli_num_rows($res);
						$sn=1; //variable pour ajuster le num de l'admin à l'affichage

						if($count>0){
							while($rows=mysqli_fetch_assoc($res)){
								$id= $rows['id'];
								$full_name= $rows['full_name'];
								$username= $rows['username'];

								?>
									<tr>
										<td><?php echo $sn++; ?></td>
										<td><?php echo $full_name; ?></td>
										<td><?php echo $username; ?></td>
										<td>
											<a href='<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>' class="btn-primary">Modifier le mdp</a>
											<a href='<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>' class="btn-secondary">Modifier l'admin</a>
											<a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Supprimer l'admin</a>
										</td>
									</tr>
								<?php
							}
						}
					}
				?>
			</table>
		</div>
	</div>

<?php include('partials/footer.php')?>
		