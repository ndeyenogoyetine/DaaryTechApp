<?php
require_once("model/ServiceReaRepository.php");
$serviceReaRepository = new ServiceReaRepository();

try {
    $listeServices = $serviceReaRepository->getAllByEtatAndType(1, 'S');
} catch (Exception $error) {
    echo "<p>Erreur lors du chargement des services : " . $error->getMessage() . "</p>";
    $listeServices = [];
}
?>

<div id="service" class="content" data-scrollview="true">
    <div class="container">
        <h2 class="content-title">Nos Services</h2>
        <p class="content-desc">
            Vous trouverez ci-dessous les services proposés par l'entreprise Daary Technologie.
        </p>

        <div class="row">
            <?php if (!empty($listeServices)) : ?>
                <?php foreach ($listeServices as $service) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="service">
                            <div class="icon" data-animation="true" data-animation-type="bounceIn">
                                <img height="50px"
                                    src="public/images/servicesRea/<?= htmlspecialchars(basename($service['photo'])) ?>"
                                    alt="Photo service" />
                            </div> <!-- ✅ ferme .icon -->
                            <div class="info">
                                <h4 class="title">
                                    <?= htmlspecialchars($service['nom']) ?>
                                </h4>
                                <p class="desc" data-toggle="tooltip" data-placement="top"
                                    title="<?= htmlspecialchars($service['description']) ?>">
                                    <?= htmlspecialchars(mb_substr($service['description'], 0, 40))
                                        . (mb_strlen($service['description']) > 40 ? "... lire plus" : "") ?>
                                </p>
                            </div> <!-- ✅ ferme .info -->
                        </div> <!-- ✅ ferme .service -->
                    </div> <!-- ferme .col-lg-4 -->
                <?php endforeach; ?>
            <?php else : ?>
                <p class="alert alert-danger text-center h3 fw-bold">Aucun service trouvé !</p>
            <?php endif; ?>
        </div>
    </div>
</div>