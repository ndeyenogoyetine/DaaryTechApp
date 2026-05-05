<!-- =========  Récupération liste Equipe s dans la BD  =========== -->
<?php
require_once("model/UserRepository.php");
$userRepository = new UserRepository();

try {
	$listeUsers = $userRepository->getAll(1, 'Equipe');
} catch (Exception $error) {
	echo "<p>Erreur lors du chargement de la liste des réalisations : " . $error->getMessage() . "</p>";
	$listeUsers = [];
}
?>


<div id="team" class="content" data-scrollview="true">
	<div class="container">
		<h2 class="content-title">Notre Equipe</h2>
		<!-- <p class="content-desc">
					Phasellus suscipit nisi hendrerit metus pharetra dignissim. Nullam nunc ante, viverra quis<br /> 
					ex non, porttitor iaculis nisi.
				</p> -->
		<div class="row">
			<?php if (!empty($listeUsers)) : ?>
				<?php foreach ($listeUsers as $user) : ?>
					<div class="col-lg-4">
						<div class="team">
							<div class="image" data-animation="true" data-animation-type="flipInX">
								<img  height="200px;" style="border: 1px dashed #222;"
								 src="public/images/users/<?= htmlspecialchars(basename($user['photo'])) ?>" alt="user" />
							</div>
							<div class="info">
								<h3 class="name"><?= $user['nom'] ?></h3>
								<div class="title text-primary"><?= $user['role'] ?></div>
								<div class="social">
									<a href="#"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
									<a href="#"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
									<a href="#"><i class="fab fa-google-plus-g fa-lg fa-fw"></i></a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<p class=" col-lg-12 alert alert-danger text-center h3 fw-bold">Aucune utilisateur trouvée !</p>
			<?php endif; ?>

		</div>
	</div>
</div>