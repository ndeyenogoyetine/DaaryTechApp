
<!-- ================== BASE SCRIPT ================== -->

<script src="public/templates/templateAdmin/assets/js/app.min.js"></script>
<script src="public/templates/templateAdmin/assets/js/theme/default.min.js"></script>
<script src="public/js/global/Validator.js"></script>
<script src="public/js/user/login.js"></script>
<script src="public/js/user/confirmEmailReinitValidator.js"></script>

<!-- ================== CDN SWEET ALERT ================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
<!-- ==================  JS APP ================== -->

<script>
    function loadScriptIfPathEndswith(path, scriptSources) {
        if (window.location.pathname.endsWith(path)) {

            scriptSources.forEach(src => {
                const script = document.createElement("script");
                script.src = src;
                document.body.appendChild(script);

            });
        }
    }

    loadScriptIfPathEndswith("reinit", [
       "public/js/user/reinitPasswordFremValidator.js",
       
    ]);

     loadScriptIfPathEndswith("reinitEmail", [
      "public/js/user/confirmEmailReinitValidator.js",
         
    ]);
</script>





