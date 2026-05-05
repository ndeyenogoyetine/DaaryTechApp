<!DOCTYPE html>
<html lang="fr">
<!-- ==================  section Head ================== -->
<?php require_once("../../../sections/admin/head.php"); ?>

<body>
<!-- ==================  Vérification session ================== -->
	  <?php require_once("../../../sections/admin/verifySession.php") ;?>

	<!-- =========  Récuperation liste contact de la BD  =========== -->
	<?php
	require_once("../../../../model/ContactRepository.php");

	$contactRepository = new ContactRepository();

	try {
		$listeContact = $contactRepository->getAll();
	} catch (Exception $error) {
		echo "<p>Erreur lors du chargement de la liste des Contacts : " . $error->getMessage() . "</p>";
		$listeContact = [];
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
					<a href="listecontact" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">contacts</a>
				</li>
				<li id="btn-show-liste-contacts" class="breadcrumb-item">
					<a href="listeServiceRea" class="btn btn-sm btn-dark text-white fw-bold">Réalisation</a>
				</li>
			</ol>
			<h1 class="page-header"> # contacts </h1>

			<!-- ================== Liste contacts ================== -->
			<div id="table-liste-contact" class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Liste des Contactes</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<!-- ✅ FIX: ID unique "data-table-contacts" -->
					<table id="data-table-contacts" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th class="text-nowrap text-center">Nom</th>
								<th class="text-nowrap text-center">Email</th>
								<th class="text-nowrap text-center">Sujet</th>
								<th class="text-nowrap text-center">Message</th>
								<th class="text-nowrap text-center">Créer le</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($listeContact)) : ?>
								<?php foreach ($listeContact as $contact) : ?>
									<tr class="odd gradeX">

										<!-- Nom -->
										<td class="text-center">
											<?= htmlspecialchars($contact['nom']) ?>
										</td>

                                        <!-- Email -->
										<td class="text-center">
											<?= htmlspecialchars($contact['email']) ?>
										</td>

										<!-- Sujet -->
										<td class="text-center">
											<?= htmlspecialchars($contact['sujet']) ?>
										</td>

										<!-- Message -->
										<td>
											<span data-toggle="tooltip" data-placement="top"
												title="<?= htmlspecialchars($contact['message']) ?>">
												<?= htmlspecialchars(mb_substr($contact['message'], 0, 50)) .
													(strlen($contact['message']) > 50 ? "... lire plus" : "") ?>
											</span>
										</td>

								
										<!-- Créer le -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($contact['created_at']))) ?>
										</td>
									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<tr>
									<td colspan="9">
										<p class="alert alert-danger text-center h3 f-w-700">La liste des contacts est vide !</p>
									</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>

		<!-- ================== section config ================== -->
		<?php require_once("../../../sections/admin/config.php"); ?>

		<!-- ================== scroll to top btn ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top">
			<i class="fa fa-angle-up"></i>
		</a>

	</div><!-- fin #page-container -->

	<!-- ================== section script ================== -->
	<?php require_once("../../../sections/admin/script.php"); ?>

	<!-- ================== section messages erreur/succès ================== -->
	<?php require_once("../../../sections/admin/msgErrorSuccess.php"); ?>


</body>
</html>