<!DOCTYPE html>
<html lang="en">
<!-- ==================  section Head ================== -->
<?php require_once("../../../sections/admin/head.php"); ?>

<body>

<!-- ==================  Vérification session ================== -->
	  <?php require_once("../../../sections/admin/verifySession.php") ;?>

	<!-- =========  Récuperation lise serviceRea de la BD  =========== -->
	<?php
	require_once("../../../../model/ServiceReaRepository.php");

	$serviceReaRepository = new ServiceReaRepository();

	try {
		$listeServiceReas =	$serviceReaRepository->getAll(1);
		$listeServiceReasSUpprimer = $serviceReaRepository->getAll(0);
	} catch (Exception $error) {
		echo "<p>Erreur lors du chargement de la liste des serviceRea"  . $error->getMessage() . "</p>";
		$listeServiceReas = [];
	}
	?>
	<!-- ==================  section Loader ================== -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>

	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- ==================  section Menu Heaut ================== -->
		<?php require_once("../../../sections/admin/menuHeaut.php"); ?>

		<!-- ================== section Menu Gauche ================== -->

		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		<!-- ==================  section  Content ================== -->
		<div id="content" class="content">
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item">
					<a href="#modal-add-service-rea" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a></li>
				<li id="btn-show-liste" class="breadcrumb-item"><a href="#" class="btn btn-sm btn-dark text-white fw-bold">Afficher Liste</a></li>
				<li id="btn-show-corbeille" class="breadcrumb-item"><a href="#" class="btn btn-sm btn-dark text-white fw-bold">Afficher Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="listeUser" class="btn btn-sm btn-dark text-white fw-bold">User</a></li>
			</ol>
			<h1 class="page-header"> # Service / Realisation </h1>

			<!-- Liste normal Service / Realisation-->
			<div id="table-liste" class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Liste Service / Realisation</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%" data-orderable="false">Photo</th>
								<th class="text-nowrap text-center">Non</th>
								<th class="text-nowrap text-center">Description</th>
								<th class="text-nowrap text-center">Type</th>
								<th class="text-nowrap text-center">Créer le</th>
								<th class="text-nowrap text-center">Modofier le</th>
								<th class="text-nowrap text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($listeServiceReas)) : ?>
								<?php foreach ($listeServiceReas as $serviceRea) : ?>
									<tr class="odd gradeX">

										<!-- Photo -->
										<td width="1%" class="with-img text-center">
											<?php if (!empty($serviceRea['photo'])) : ?> 
												<img src="public/images/servicesRea/<?= htmlspecialchars($serviceRea['photo']); ?>"
												style="width: 40px;"class="img-rounded height-30" />
											<?php else : ?>
												<img src="public/images/servicesRea/default.jpg"
												 style="width: 40px;"class="img-rounded height-30" />
											<?php endif ?>
										</td>

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['nom']) ?>
										</td>

										<!-- Description -->
										<td>
											<span data-toggle="tooltip" data-placement="top"
												title="<?= htmlspecialchars($serviceRea['description']) ?>">
												<?= htmlspecialchars(mb_substr($serviceRea['description'], 0, 20)) .
													(strlen($serviceRea['description']) > 20 ? "... lire plus" : "") ?>
											</span>
										</td>

										<!-- Type -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['type'] === 'R' ? "Rearlisation" : "Service") ?>
										</td>

                                        <!-- Créer le -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:is"), strtotime($serviceRea['created_at'])) ?> </br>
											par <?= htmlspecialchars($serviceRea['created_by_email']) ?>
										</td>

										<!-- Modifier le -->
										<td class="text-center">
											<?php if ($serviceRea['updated_at']) : ?>
												<?= htmlspecialchars(date("d/m/Y H:is"), strtotime($serviceRea['updated_at'])) ?> </br>
											    par <?= htmlspecialchars($serviceRea['updated_by_email']) ?>
											<?php else : ?>
                                                     <span class='text-danger  f-w-700'>jamais modifier</span>
											<?php endif ?>
										</td>
                                    <!-- Actions -->
										<td class="text-center">
											<!-- Ediction -->
                                          <a href="javascript:;"
										     data-id="<?= htmlspecialchars($serviceRea['id']) ?>"
										     data-nom="<?= htmlspecialchars($serviceRea['nom']) ?>"
										     data-description="<?= htmlspecialchars($serviceRea['description']) ?>"
										     data-type="<?= htmlspecialchars($serviceRea['type']) ?>"
										     data-photo="<?= htmlspecialchars($serviceRea['photo']) ?>"
											 class="btn-edit" data-toggle="modal" data-target="#modal-edit-service-rea" tetle="Modifier"

										  >
											<i class="fa fa-edit btn btn-success  fw-bold"></i>
										  </a>

										  <!-- Suppression -->
                                          <a href="#" 
										  data-id="<?= htmlspecialchars($serviceRea['id']) ?>"
										   name-servicerea="<?= htmlspecialchars($serviceRea['nom']) ?>" 
										   class="btn-delete" data-toggle="tooltip" data-placement="top" title="Supprimer">
											<i class="fa fa-trash btn btn-danger fw-bold"></i>
										  </a>
										</td>

									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<p class="alert alert-danger text-center h3 f-w-700">La liste des services / Realisation est viede !</p>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>

          <!-- Corgielle Service / Realisation -->
			<div id="table-corbille" class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Corbeille Service / Realisation</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%" data-orderable="false">Photo</th>
								<th class="text-nowrap text-center">Non</th>
								<th class="text-nowrap text-center">Description</th>
								<th class="text-nowrap text-center">Type</th>
								<th class="text-nowrap text-center">Créer le</th>
								<th class="text-nowrap text-center">Modofier le</th>
								<th class="text-nowrap text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($listeServiceReasSUpprimer)) : ?>
								<?php foreach ($listeServiceReasSUpprimer as $serviceRea) : ?>
									<tr class="odd gradeX">

										<!-- Photo -->
										<td width="1%" class="with-img text-center">
											<?php if (!empty($serviceRea['photo'])) : ?> 
												<img src="public/images/servicesRea/<?= htmlspecialchars($serviceRea['photo']); ?>"
												style="width: 40px;"class="img-rounded height-30" />
											<?php else : ?>
												<img src="public/images/servicesRea/default.jpg"
												 style="width: 40px;"class="img-rounded height-30" />
											<?php endif ?>
										</td>

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['nom']) ?>
										</td>

										<!-- Description -->
										<td>
											<span data-toggle="tooltip" data-placement="top"
												title="<?= htmlspecialchars($serviceRea['description']) ?>">
												<?= htmlspecialchars(mb_substr($serviceRea['description'], 0, 20)) .
													(strlen($serviceRea['description']) > 20 ? "... lire plus" : "") ?>
											</span>
										</td>

										<!-- Type -->
										<td class="text-center">
											<?= htmlspecialchars($serviceRea['type'] === 'R' ? "Rearlisation" : "Service") ?>
										</td>

                                        <!-- Créer le -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s"), strtotime($serviceRea['created_at'])) ?> </br>
											par <?= htmlspecialchars($serviceRea['created_by_email']) ?>
										</td>

										<!-- Modifier le -->
										<td class="text-center">
											<?php if ($serviceRea['updated_at']) : ?>
												<?= htmlspecialchars(date("d/m/Y H:i:s"), strtotime($serviceRea['updated_at'])) ?> </br>
											    par <?= htmlspecialchars($serviceRea['updated_by_email']) ?>
											<?php else : ?>
                                                     <span class='text-danger  f-w-700'>jamais modifier</span>
											<?php endif ?>
										</td>
                                    <!-- Actions -->
										<td class="text-center">
										<!-- Rastaurer -->
                                          <a href="#" 
										  data-id="<?= htmlspecialchars($serviceRea['id']) ?>"
										   name-servicerea="<?= htmlspecialchars($serviceRea['nom']) ?>" 
										   class="btn-restaurer" data-toggle="tooltip" data-placement="top" title="Restaurer">
											<span class="btn btn-warning f-w-700">Rastaurer</span>
										  </a>

										  <!-- Suppréssion définitive -->
                                           <!-- <a href="#" 
										  data-id="<?= htmlspecialchars($serviceRea['id']) ?>"
										   name-servicerea="<?= htmlspecialchars($serviceRea['nom']) ?>" 
										   class="btn-delete-definitive" data-toggle="tooltip" data-placement="top" title="Suppréssion définitive">
											<span class="btn btn-danger fw-bold">Sup Def</span>
										  </a> -->

										</td>
									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<p class="alert alert-danger text-center h3 f-w-700">Aucun services ou Realisation supprimé !</p>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- ================== section config ================== -->
		<?php require_once("../../../sections/admin/config.php"); ?>

		<!-- ================== section scroll to top btn ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

	</div>

	<!-- ================== Model Add Service / Realisation ================== -->
	<div class="modal fade" id="modal-add-service-rea" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- HEADER -->
				<div class="modal-header">
					<h4 class="modal-title">Ajouter une réalisation</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- BODY : FORMULAIRE -->
				<div class="modal-body">
					<form action="serviceRearMainController" method="post" enctype="multipart/form-data" id="addRealisationFrom">
						<!-- Nom -->
						<div class="form-group">
							<label for="nom">Nom</label>
							<input type="text" name="nom" class="form-control" id="nom" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Description -->
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" name="description" id="description" rows="3" required></textarea>
							<p class="error-message mt-2"></p>

						</div>
						<!-- Photo -->
						<div class="form-group">
							<label for="photo">Photo</label>
							<input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Type -->
						<div class="form-group">
							<label for="type">Type</label>
							<select class="form-control" name="type" id="type" required>
								<option value="">-- Sélectionnez un type --</option>
								<option value="R">Réalisation</option>
								<option value="S">Service</option>
							</select>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Soumission -->
						<div style="display: flex; justify-content:center;">
							<button type="submit" name="frmAddServiceRea" class="btn btn-primary" fw-bold> Ajouter</button> &nbsp;
							<button type="reset" class="btn btn-danger fw-bold"> Annuler</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- ================== Model Edit Service / Realisation ================== -->
	<div class="modal fade" id="modal-edit-service-rea" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- HEADER -->
				<div class="modal-header">
					<h4 class="modal-title">Modifier une réalisation</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- BODY : FORMULAIRE -->
				<div class="modal-body">
					<form action="serviceRearMainController" method="post" enctype="multipart/form-data" id="editRealisationFrom">
						<!-- Nom -->
						<div class="form-group">
							<label for="nom">Nom</label>
							<input type="text" name="edit-nom" class="form-control" id="edit-nom" required>
							<p class="error-message mt-2"></p>
						</div>
						<!-- Description -->
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" name="edit-description" id="edit-description" rows="3" required></textarea>
							<p class="error-message mt-2"></p>

						</div>
						<!-- Photo -->
						<div class="form-group">
							<label for="photo">Photo</label>
							<input type="file" name="edit-photo" id="edit-photo" class="form-control" accept="image/*" required>
							<p class="error-message mt-2"></p>
							<div class="image-preview-container">
							<img src="" id="photo-preview" alt="Aperçu de l'imag">
							</div>
							
						</div>
						<!-- Type -->
						<div class="form-group">
							<label for="type">Type</label>
							<select class="form-control" name="edit-type" id="edit-type" required>
								<option value="">-- Sélectionnez un type --</option>
								<option value="R">Réalisation</option>
								<option value="S">Service</option>
							</select>
							<p class="error-message mt-2"></p>
						</div>

						<input type="text" name="edit-id" hidden id="edit-id" value="">
						<!-- Soumission -->
						<div style="display: flex; justify-content:center;">
							<button type="submit" name="frmEditServiceRea" class="btn btn-primary" fw-bold> Modifier</button> &nbsp;
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- ================== section script ================== -->
	<?php require_once("../../../sections/admin/script.php"); ?>

	<!-- ================== section script ================== -->
	<?php require_once("../../../sections/admin/msgErrorSuccess.php"); ?>



</body>

</html>