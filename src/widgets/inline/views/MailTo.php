<?php declare(strict_types=1);

/** @var string $email */
?>

<script>
(function () {
  var email = atob('<?= base64_encode($email); ?>');
  document.write('<a rel="nofollow" href="mailto:' + email + '">' + email + '</a>');
})();
</script>
