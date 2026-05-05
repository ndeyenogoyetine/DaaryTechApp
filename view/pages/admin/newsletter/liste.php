<!DOCTYPE html>
<html lang="fr">
<!-- ==================  section Head ================== -->
<?php require_once("../../../sections/admin/head.php"); ?>

<body>
<!-- ==================  Vérification session ================== -->
	  <?php require_once("../../../sections/admin/verifySession.php") ;?>

	<!-- =========  Récuperation liste newsletter de la BD  =========== -->
	<?php
	require_once("../../../../model/NewsletterRepository.php");

	$newsletterRepository = new NewsletterRepository();

	try {
		$listeNewsletter = $newsletterRepository->getAll();
	} catch (Exception $error) {
		echo "<p>Erreur lors du chargement de la liste des newsletters : " . $error->getMessage() . "</p>";
		$listeNewsletter = [];
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
					<a href="#modal-send-message" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">
						Envoyé un message aux abonnés
					</a>
				</li>

				<li class="breadcrumb-item">
					<a href="listeContact" class="btn btn-sm btn-dark text-white fw-bold" >Contact</a>
				</li>
				<li id="btn-show-liste-newsletters" class="breadcrumb-item">
					<a href="listeServiceRea" class="btn btn-sm btn-dark text-white fw-bold">Réalisation</a>
				</li>
			</ol>
			<h1 class="page-header"> # Newsletters </h1>

			<!-- ================== Liste newsletters ================== -->
			<div id="table-liste-newsletter" class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Liste des newsletteres</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<!-- ✅ FIX: ID unique "data-table-newsletters" -->
					<table id="data-table-newsletters" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th class="text-nowrap text-center">Idantifiant</th>
								<th class="text-nowrap text-center">Email</th>
								<th class="text-nowrap text-center">Créer le</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($listeNewsletter)) : ?>
								<?php foreach ($listeNewsletter as $newsletter) : ?>
									<tr class="odd gradeX">									
									 <!-- Id -->
										<td class="text-center">
											<?= htmlspecialchars($newsletter['id']) ?>
										</td>

                                        <!-- Email -->
										<td class="text-center">
											<?= htmlspecialchars($newsletter['email']) ?>
										</td>

										<!-- Créer le -->
										<td class="text-center">
											<?= htmlspecialchars(date("d/m/Y H:i:s", strtotime($newsletter['created_at']))) ?>
										</td>
									</tr>
								<?php endforeach ?>
							<?php else : ?>
								<tr>
									<td colspan="9">
										<p class="alert alert-danger text-center h3 f-w-700">La liste des newsletters est vide !</p>
									</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>

        <!-- ================== Modal send Message ================== -->
	<div class="modal fade" id="modal-send-message" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Envoi de message aux abonnés</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="newsletterMainController" method="post" id="sendMessageForme">

		               <!-- Description -->
						<div class="form-group">
							<label for="message">Message</label>
							<textarea class="form-control" name="message" id="message" rows="3" required placeholder="Entrez votre message"></textarea>
							<p class="error-message mt-2"></p>

						</div>
						<!-- Soumission -->
						<div style="display: flex; justify-content: center;">
							<button type="submit" name="frmSendMessage" class="btn btn-primary fw-bold">Envoié</button>
							&nbsp;
						</div>
					</form>
				</div>
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