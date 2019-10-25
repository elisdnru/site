<?php
/** @var $email string */
?>

<script>
(function () {
  var email = atob('<?= base64_encode($email) ?>');
  document.write('<a rel="nofollow" href="mailto:' + email + '">' + email + '</a>');
})();
</script>
