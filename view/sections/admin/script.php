<!-- ================== GLOBAL JS ================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- ================== BEGIN BASE JS ================== -->
<script src="public/templates/templateAdmin/assets/js/app.min.js"></script>
<script src="public/templates/templateAdmin/assets/js/theme/default.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="public/templates/templateAdmin/assets/plugins/d3/d3.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/nvd3/build/nv.d3.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/jvectormap-next/jquery-jvectormap-world-mill.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/moment/min/moment.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="public/templates/templateAdmin/assets/js/demo/dashboard-v3.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="public/templates/templateAdmin/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="public/templates/templateAdmin/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="public/templates/templateAdmin/assets/js/demo/table-manage-default.demo.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<!-- ================== CDN SWEET ALERT ================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- ================== GLOBAL JS ================== -->
<script src="public/js/global/Validator.js"></script>

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

    loadScriptIfPathEndswith("listeServiceRea", [

        "public/js/serviceRea/addFremValidator.js",
        "public/js/serviceRea/editFremValidator.js",
        "public/js/serviceRea/confirmeDelete.js",
        "public/js/serviceRea/confirmeRestaurer.js",
        "public/js/serviceRea/confirmeDeleteDef.js",
        "public/js/serviceRea/showHide.js"

    ]);

     loadScriptIfPathEndswith("listeUser", [

          "public/js/user/addFremValidator.js",
          "public/js/user/editFremValidator.js",
          "public/js/user/confirmeDelete.js",
         "public/js/user/confirmeRestaurer.js",
          "public/js/user/showHide.js",
          "public/js/user/changePasswordFremValidator.js"
          
 
    ]);
</script>

