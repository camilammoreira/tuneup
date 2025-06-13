</div>
</div>
</div>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-3.3.1.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/popper.min.js"> </script>
<script src="<?php echo BASE_URL; ?>js/bootstrap.min.js"> </script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.escolha').select2({ placeholder: "Selecione.." });
    });
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="modal"]').tooltip();
    });
</script>
</body>

</html>