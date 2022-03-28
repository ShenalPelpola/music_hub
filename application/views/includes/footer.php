</main>

<?php if (!$this->session->userdata('authorized')) : ?>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"> </script>
    <script src="<?php echo base_url('assets/js/script-private.js'); ?>"> </script>
<?php endif; ?>

<?php if ($this->session->userdata('authorized')) : ?>
    <script src="<?php echo base_url('assets/js/script-private.js'); ?>"> </script>
<?php endif; ?>

</body>

</html>