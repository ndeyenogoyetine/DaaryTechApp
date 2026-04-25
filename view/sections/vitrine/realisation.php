<!-- =========  Récupération liste des réalisations dans la BD  =========== -->
<?php
require_once("model/ServiceReaRepository.php");
$serviceReaRepository = new ServiceReaRepository();

try {
    $listeRealisations = $serviceReaRepository->getAllByEtatAndType(1, 'R');
} catch (Exception $error) {
    echo "<p>Erreur lors du chargement de la liste des réalisations : " . $error->getMessage() . "</p>";
    $listeRealisations = [];
}
?>

<!-- =========  Tableau liste Réalisations  =========== -->
<div id="work" class="content" data-scrollview="true">

    <div class="container" data-animation="true" data-animation-type="fadeInDown">
        <!-- Titre -->
        <h2 class="content-title">Nos Réalisations</h2>
        <p class="content-desc">
            Vous trouverez ci-dessous, les réalisations de l'entreprise Daary Technologie.
        </p>

        <!-- Liste des réalisations -->
        <div class="row row-space-10">
            <?php if (!empty($listeRealisations)) : ?>
                <?php foreach ($listeRealisations as $realisation) : ?>

                    <div class="col-lg-3 col-md-4">
                        <div class="work">
                            <!-- Photo -->
                            <div class="image">
                                <a href="realisation.php?id=<?=$realisation['id'] ?>">
                                    <img height="300px;" style="border: 1px dashed #222;"
                                        src="public/images/servicesRea/<?= htmlspecialchars(basename($realisation['photo'])) ?>"
                                        alt="Photo réalisation" />
                                </a>
                            </div>
                            <div class="desc">
                                <span class="desc-title">
                                    <?= htmlspecialchars($realisation['nom']) ?>
                                </span>

                                <span class="desc-text" data-toggle="tooltip" data-placement="top"
                                    title="<?= htmlspecialchars($realisation['description']) ?>">
                                    <?= htmlspecialchars(mb_substr($realisation['description'], 0, 50))
                                        . (mb_strlen($realisation['description']) > 50 ? "... lire plus" : "") ?>
                                </span>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <p class="alert alert-danger text-center h3 fw-bold">Aucune réalisation trouvée !</p>
            <?php endif; ?>
        </div>

    </div>

</div>