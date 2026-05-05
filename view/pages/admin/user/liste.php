<!DOCTYPE html>
<html lang="fr">
<!-- ==================  section Head ================== -->
<?php require_once("../../../sections/admin/head.php"); ?>

<body>
<!-- ==================  Vérification session ================== -->
	  <?php require_once("../../../sections/admin/verifySession.php") ;?>

	<!-- =========  Récuperation liste user de la BD  =========== -->
	<?php
	require_once("../../../../model/userRepository.php");

	$userRepository = new UserRepository();

	try {
		$listeUsers = $userRepository->getAll(1);
		$listeUsersSUpprimer = $userRepository->getAll(0);
	} catch (Exception $error) {
		echo "<p>Erreur lors du chargement de la liste des users : " . $error->getMessage() . "</p>";
		$listeUsers = [];
		$listeUsersSUpprimer = [];
	}
	?>

	<!-- ==================  section Loader ================== -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>

	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

		<!-- ==================  section Menu Haut ================== -->
		<?php require_once("../../../sections/admin/menuHeaut.php"); ?>

		<!-- ================== section Menu Gauche ================== -->
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		<!-- ==================  section Content ================== -->
		<div id="content" class="content">
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item">
					<a href="#modal-add-user" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li>
				<li id="btn-show-liste-users" class="breadcrumb-item">
					<a href="#" class="btn btn-sm btn-dark text-white fw-bold">Afficher Liste</a>
				</li>
				<li id="btn-show-corbeille-users" class="breadcrumb-item">
					<a href="#" class="btn btn-sm btn-dark text-white fw-bold">Afficher Corbeille</a>
				</li>
				<li class="breadcrumb-item">
					<a href="#modal-change-password" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Changer mot de passe</a>
				</li>
			</ol>
			<h1 class="page-header"> # Users </h1>

			<!-- ================== Liste Users ================== -->
			<div id="table-liste-user" class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Liste des Utilisateurs</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<!-- ✅ FIX: ID unique "data-table-users" -->
					<table id="data-table-users" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%" data-orderable="false">Photo</th>
								<th class="text-nowrap text-center">Nom</th>
								<th class="text-nowrap text-center">Adresse</th>
								<th class="text-nowrap text-center">Telephone</th>
								<th class="text-nowrap text-center">Email</th>
								<th class="text-nowrap text-center">Role</th>
								<th class="text-nowrap text-center">Créer le</th>
								<th class="text-nowrap text-center">Modifier le</th>
								<th class="text-nowrap text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($listeUsers)) : ?>
								<?php foreach ($listeUsers as $user) : ?>
									<tr class="odd gradeX">

										<!-- Photo -->
										<td width="1%" class="with-img text-center">
											<?php if (!empty($user['photo'])) : ?>
												<img src="public/images/users/<?= htmlspecialchars($user['photo']); ?>"
													style="width: 40px;" class="img-rounded height-30" />
											<?php else : ?>
												<img src="public/images/users/default-user.jpg"
													style="width: 40px;" class="img-rounded height-30" />
											<?php endif ?>
										</td>

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($user['nom']) ?>
										</td>

										<!-- Adresse -->
										<td class="text-center">
											<?= htmlspecialchars($user['adresse']) ?>
										</td>

										<!-- Téléphone -->
										<td class="text-center">
											<?= htmlspecialchars($user['telephone']) ?>
										</td>

										<!-- Email -->
										<td class="text-center">
											<?= htmlspecialchars($user['email']) ?>
										</td>

										<!-- Role -->
										<td class="text-center">
											<?= htmlspecialchars($user['role']) ?>
										</td>

										<!-- Créer le -->
										<!-- ✅ FIX: strtotime() doit être le 2e arg de date(), pas de htmlspecialchars() -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['created_at']))) ?>
											<br> par
											<?php if (!empty($user['created_by_email'])) : ?>
												<?= htmlspecialchars($user['created_by_email']) ?>
											<?php else : ?>
												<span class='f-w-700'>admin@gmail.com</span>
											<?php endif ?>
										</td>

										<!-- Modifier le -->
										<td class="text-center">
											<?php if (!empty($user['updated_at'])) : ?>
												<?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['updated_at']))) ?>
												<br> par <?= htmlspecialchars($user['updated_by_email']) ?>
											<?php else : ?>
												<span class='text-danger f-w-700'>jamais modifié</span>
											<?php endif ?>
										</td>

										<!-- Actions -->
										<td class="text-center">
											<!-- Edition -->
											<a href="javascript:;"
												data-id="<?= htmlspecialchars($user['id']) ?>"
												data-nom="<?= htmlspecialchars($user['nom']) ?>"
												data-adresse="<?= htmlspecialchars($user['adresse']) ?>"
												data-telephone="<?= htmlspecialchars($user['telephone']) ?>"
												data-email="<?= htmlspecialchars($user['email']) ?>"
												data-role="<?= htmlspecialchars($user['role']) ?>"
												data-photo="<?= htmlspecialchars($user['photo']) ?>"
												class="btn-edit-user"
												data-toggle="modal"
												data-target="#modal-edit-user"
												title="Modifier">
												<i class="fa fa-edit btn btn-success fw-bold"></i>
											</a>

											<!-- Suppression -->
											<a href="#"
												data-id-user="<?= htmlspecialchars($user['id']) ?>"
												data-name-user="<?= htmlspecialchars($user['nom']) ?>"
												class="btn-delete-user"
												data-toggle="tooltip"
												data-placement="top"
												title="Supprimer">
												<i class="fa fa-trash btn btn-danger f-w-700"></i>
											</a>
										</td>

									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<tr>
									<td colspan="9">
										<p class="alert alert-danger text-center h3 f-w-700">La liste des utilisateurs est vide !</p>
									</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- ================== Corbeille Users ================== -->
			<div id="table-corbille-user" class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Corbeille Users</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<!-- ✅ FIX: ID unique "data-table-corbeille" -->
					<table id="data-table-corbeille" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%" data-orderable="false">Photo</th>
								<th class="text-nowrap text-center">Nom</th>
								<th class="text-nowrap text-center">Adresse</th>
								<th class="text-nowrap text-center">Telephone</th>
								<th class="text-nowrap text-center">Email</th>
								<th class="text-nowrap text-center">Role</th>
								<th class="text-nowrap text-center">Créer le</th>
								<th class="text-nowrap text-center">Modifier le</th>
								<th class="text-nowrap text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($listeUsersSUpprimer)) : ?>
								<?php foreach ($listeUsersSUpprimer as $user) : ?>
									<tr class="odd gradeX">

										<!-- Photo -->
										<td width="1%" class="with-img text-center">
											<?php if (!empty($user['photo'])) : ?>
												<img src="public/images/users/<?= htmlspecialchars($user['photo']); ?>"
													style="width: 40px;" class="img-rounded height-30" />
											<?php else : ?>
												<img src="public/images/users/default-user.jpg"
													style="width: 40px;" class="img-rounded height-30" />
											<?php endif ?>
										</td>

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($user['nom']) ?>
										</td>

										<!-- Adresse -->
										<td class="text-center">
											<?= htmlspecialchars($user['adresse']) ?>
										</td>

										<!-- Téléphone -->
										<td class="text-center">
											<?= htmlspecialchars($user['telephone']) ?>
										</td>

										<!-- Email -->
										<td class="text-center">
											<?= htmlspecialchars($user['email']) ?>
										</td>

										<!-- Role -->
										<td class="text-center">
											<?= htmlspecialchars($user['role']) ?>
										</td>

										<!-- Créer le -->
										<!-- ✅ FIX: strtotime() doit être le 2e arg de date() -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['created_at']))) ?>
											<br> par
											<?php if (!empty($user['created_by_email'])) : ?>
												<?= htmlspecialchars($user['created_by_email']) ?>
											<?php else : ?>
												<span class='f-w-700'>admin@gmail.com</span>
											<?php endif ?>
										</td>

										<!-- Modifier le -->
										<td class="text-center">
											<?php if (!empty($user['updated_at'])) : ?>
												<?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($user['updated_at']))) ?>
												<br> par <?= htmlspecialchars($user['updated_by_email']) ?>
											<?php else : ?>
												<span class='text-danger f-w-700'>jamais modifié</span>
											<?php endif ?>
										</td>

										<!-- Actions -->
										<td class="text-center">
											<!-- Restaurer -->
											<!-- ✅ FIX: attributs data-confirm-id-user et data-confirm-nom-user corrects -->
											<a href="#"
												data-confirm-id-user="<?= htmlspecialchars($user['id']) ?>"
												data-confirm-nom-user="<?= htmlspecialchars($user['nom']) ?>"
												class="btn-restaurer-user"
												data-toggle="tooltip"
												data-placement="top"
												title="Restaurer">
												<span class="btn btn-warning f-w-700">Restaurer</span>
											</a>
										</td>

									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<tr>
									<td colspan="9">
										<p class="alert alert-danger text-center h3 f-w-700">La corbeille est vide !</p>
									</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>

		</div><!-- fin #content -->

		<!-- ================== section config ================== -->
		<?php require_once("../../../sections/admin/config.php"); ?>

		<!-- ================== scroll to top btn ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top">
			<i class="fa fa-angle-up"></i>
		</a>

	</div><!-- fin #page-container -->


	<!-- ================== Modal Add User ================== -->
	<div class="modal fade" id="modal-add-user" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ajouter un utilisateur</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="UserMainController" method="post" enctype="multipart/form-data" id="addUserFrom">
						<!-- Nom -->
						<div class="form-group">
							<label for="user-nom">Nom</label>
							<input type="text" name="user-nom" class="form-control" id="user-nom" placeholder="Nom" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Adresse -->  
						<div class="form-group">
							<label for="user-adresse">Adresse</label>
							<input type="text" name="user-adresse" class="form-control" id="user-adresse" placeholder="Adresse" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Téléphone -->
						<div class="form-group">
							<label for="user-telephone">Téléphone</label>
							<input type="tel" name="user-telephone" class="form-control" id="user-telephone" placeholder="Téléphone" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Email -->
						<!-- ✅ FIX: type="email" au lieu de type="tel" -->
						<div class="form-group">
							<label for="user-email">Email</label>
							<input type="email" name="user-email" class="form-control" id="user-email" placeholder="Email" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Photo -->
						<div class="form-group">
							<label for="user-photo">Photo</label>
							<input type="file" name="user-photo" id="user-photo" class="form-control" accept="image/*">
							<p class="error-message mt-2"></p>
						</div>
						<!-- Role -->
						<div class="form-group">
							<label for="user-role">Role</label>
							<select class="form-control" name="user-role" id="user-role" required>
								<option value="">-- Sélectionnez un role --</option>
								<option value="Admin">Admin</option>
								<option value="Equipe">Equipe</option>
							</select>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Soumission -->
						<div style="display: flex; justify-content: center;">
							<button type="submit" name="frmAddUser" class="btn btn-primary fw-bold">Ajouter</button>
							&nbsp;
							<button type="reset" class="btn btn-danger fw-bold">Annuler</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- ================== Modal Edit User ================== -->
	<div class="modal fade" id="modal-edit-user" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Modifier un utilisateur</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="UserMainController" method="post" enctype="multipart/form-data" id="editUserFrom">
						<!-- Nom -->
						<div class="form-group">
							<label for="edit-user-nom">Nom</label>
							<input type="text" name="edit-user-nom" class="form-control" id="edit-user-nom" placeholder="Nom" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Adresse -->
						<div class="form-group">
							<label for="edit-user-adresse">Adresse</label>
							<input type="text" name="edit-user-adresse" class="form-control" id="edit-user-adresse" placeholder="Adresse" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Téléphone -->
						<div class="form-group">
							<label for="edit-user-telephone">Téléphone</label>
							<input type="tel" name="edit-user-telephone" class="form-control" id="edit-user-telephone" placeholder="Téléphone" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Email -->
						<!-- ✅ FIX: type="email" au lieu de type="tel" -->
						<div class="form-group">
							<label for="edit-user-email">Email</label>
							<input type="email" name="edit-user-email" class="form-control" id="edit-user-email" placeholder="Email" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Photo -->
						<div class="form-group">
							<label for="edit-user-photo">Photo</label>
							<input type="file" name="edit-user-photo" id="edit-user-photo" class="form-control" accept="image/*">
							<div class="image-preview-container">
								<img src="" id="photo-edit-preview" alt="Aperçu de l'image">
							</div>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Role -->
						<div class="form-group">
							<label for="edit-user-role">Role</label>
							<select class="form-control" name="edit-user-role" id="edit-user-role" required>
								<option value="">-- Sélectionnez un role --</option>
								<option value="Admin">Admin</option>
								<option value="Equipe">Equipe</option>
							</select>
							<p class="error-message mt-2"></p>
						</div>
						<input type="hidden" name="edit-user-id" id="edit-user-id" value="">
						<!-- Soumission -->
						<div style="display: flex; justify-content: center;">
							<button type="submit" name="frmEditUser" class="btn btn-primary fw-bold">Modifier</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

		<!-- ================== Modal Change password ================== -->
	<div class="modal fade" id="modal-change-password" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Changer mot de passe</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="UserMainController" method="post" enctype="multipart/form-data" id="changePasswordFrom">
						<!-- Mot de passe actuel -->
						<div class="form-group">
							<label for="current_password">Mot de passe actuel</label>
							<input type="password" name="current_password" class="form-control" id="current_password" placeholder="Entrez le mot de passe actuel" required>
							<p class="error-message mt-2"></p>
						</div>
						<!--  le nouveau mot de passe -->
						<div class="form-group">
							<label for="new_password"> Nouveau mot de passe</label>
							<input type="password" name="new_password" class="form-control" id="new_password" placeholder=" Entrez le nouveau mot de passe " required>
							<p class="error-message mt-2"></p>
						</div>

						<!--  Mot de passe de confirmation -->
						<div class="form-group">
							<label for="confirme_password">confirme le mot de passe actuel</label>
							<input type="password" name="confirme_password" class="form-control" id="confirme_password" placeholder=" Confirmer le nouveau mot de passe " required>
							<p class="error-message mt-2"></p>
						</div>
						
						<!-- Soumission -->
						<div style="display: flex; justify-content: center;">
							<button type="submit" name="frmChangePassword" class="btn btn-primary fw-bold">Changer le mot de passe</button>
							&nbsp;
							<button type="reset" class="btn btn-danger fw-bold">Annuler</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- ================== section script ================== -->
	<?php require_once("../../../sections/admin/script.php"); ?>

	<!-- ================== section messages erreur/succès ================== -->
	<?php require_once("../../../sections/admin/msgErrorSuccess.php"); ?>

	<!-- ================== Scripts JS ================== -->
	<script>
		//  FIX: Délégation d'événements pour btn-delete-user (compatible DataTables)
		document.addEventListener("click", function(event) {
			const btnDelete = event.target.closest(".btn-delete-user");
			if (!btnDelete) return;
			event.preventDefault();

			const userId   = btnDelete.getAttribute('data-id-user');
			const userName = btnDelete.getAttribute('data-name-user');

			Swal.fire({
				title: `Voulez-vous supprimer l'utilisateur ${userName} ?`,
				text: "Cette action est irréversible !",
				icon: 'warning',
				showCancelButton: true,
				cancelButtonColor: '#3085d6',
				cancelButtonText: 'Annuler',
				confirmButtonColor: '#d33',
				confirmButtonText: 'Oui, supprimer',
			}).then((reponse) => {
				if (reponse.isConfirmed) {
					window.location.href = `UserMainController?id=${userId}&action=supprimer`;
				}
			});
		});

		// ✅ FIX: Délégation d'événements pour btn-restaurer-user (compatible DataTables)
		document.addEventListener("click", function(event) {
			const btnRestaurer = event.target.closest(".btn-restaurer-user");
			if (!btnRestaurer) return;
			event.preventDefault();

			const userRestaurerId   = btnRestaurer.getAttribute('data-confirm-id-user');
			const userRestaurerName = btnRestaurer.getAttribute('data-confirm-nom-user');

			Swal.fire({
				title: `Voulez-vous restaurer l'utilisateur ${userRestaurerName} ?`,
				text: "Cette action est irréversible !",
				icon: 'warning',
				showCancelButton: true,
				cancelButtonColor: '#3085d6',
				cancelButtonText: 'Annuler',
				confirmButtonColor: '#28a745',
				confirmButtonText: 'Oui, restaurer',
			}).then((reponse) => {
				if (reponse.isConfirmed) {
					window.location.href = `UserMainController?id=${userRestaurerId}&action=restaurer`;
				}
			});
		});

		// ✅ FIX: Initialisation DataTables avec IDs uniques
		$(document).ready(function() {
			$('#data-table-users').DataTable();
			$('#data-table-corbeille').DataTable();
		});

		// Remplissage modal Edit
		document.addEventListener("click", function(event) {
			const btnEdit = event.target.closest(".btn-edit-user");
			if (!btnEdit) return;

			document.getElementById('edit-user-id').value        = btnEdit.getAttribute('data-id');
			document.getElementById('edit-user-nom').value       = btnEdit.getAttribute('data-nom');
			document.getElementById('edit-user-adresse').value   = btnEdit.getAttribute('data-adresse');
			document.getElementById('edit-user-telephone').value = btnEdit.getAttribute('data-telephone');
			document.getElementById('edit-user-email').value     = btnEdit.getAttribute('data-email');
			document.getElementById('edit-user-role').value      = btnEdit.getAttribute('data-role');

			const photo = btnEdit.getAttribute('data-photo');
			if (photo) {
				document.getElementById('photo-edit-preview').src = 'public/images/users/' + photo;
			}
		});
	</script>

</body>
</html>