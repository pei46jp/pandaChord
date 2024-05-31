<?php

use Fuel\Core\Asset;

?>


<div id="root"></div>

<script>
    window.initialData = <?php echo json_encode($data, JSON_UNESCAPED_UNICODE); ?>;
</script>
<?php echo Asset::js('/main.bundle.js'); ?>

