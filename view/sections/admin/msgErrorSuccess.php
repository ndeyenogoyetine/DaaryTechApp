
		<!-- ================== Message D'Ereur ================== -->
 <!-- ================== Message D'Ereur ================== -->
 <?php if(isset($_GET['error']) && $_GET['error'] = 1 && isset($_GET['message']) && isset($_GET['title'])): ?>
    <script>
     swal.fire({
        icon: 'error',
        title: '<?php echo htmlspecialchars($_GET['title'], ENT_QUOTES, 'UTF-8')?>',
        text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8')?>'
     });
    </script>
 <?php endif; ?>
 
<!-- ================== Message Success ================== -->
<?php if(isset($_GET['success']) && $_GET['success'] = 1 && isset($_GET['message']) && isset($_GET['title'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,  
            title: '<?php echo htmlspecialchars($_GET['title'], ENT_QUOTES, 'UTF-8') ?>',
            text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8') ?>'
        });
    </script>
<?php endif; ?>