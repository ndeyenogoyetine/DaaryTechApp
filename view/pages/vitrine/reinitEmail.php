<!DOCTYPE html>
<html lang="en">

<!-- ================== Section head ================== -->
<?php require_once("../../sections/login/head.php"); ?>

<body class="pace-top">
    <!-- ================== Section Loader ================== -->
    <?php require_once("../../sections/login/loader.php"); ?>


    <div id="page-container" class="fade">

        <div class="login login-v1">
            <div class="login-container">

                <!-- Header -->
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span> <b>Confirmation mail</b>
                        <small class="ml-5">Reinitialisation du mot de passe</small>
                    </div>
                    <div class="icon"></div>
                    <i class="fa fa-lock"></i>
                </div>

                <!-- Form -->
                <div class="login-body">
                    <div class="login-content">
                        <form action="UserMainController" method="post" id="reinitConfirmMailForm" class="margin-bottom-0">

                            <!-- Email -->
                            <div class="form-group m-b-20">
                                <input type="email" id="confirmEmailReinit" name="confirmEmailReinit" class="form-control form-control-lg inverse-mode"
                                 placeholder="Confirmez votre adresse email" required />
                                <p class="error-message"></p>
                            </div>

                            <div class="login-buttons">
                                <button type="submit" id="btnSubmit" name="frmreinitConfirmMail" class="btn btn-success btn-block btn-lg">
                                    Confirmer
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================== Section Config ================== -->
        <?php require_once("../../sections/login/config.php"); ?>

        <a href="javascript:" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>
    <!-- ================== Section Javascript ================== -->
    <?php require_once("../../sections/login/script.php"); ?>
    <!-- ================== Section Message D'Ereur ================== -->
    <?php require_once("../../sections/admin/msgErrorSuccess.php"); ?>

</body>

</html>