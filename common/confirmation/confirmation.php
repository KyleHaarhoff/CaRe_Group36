<?php
    include_once __DIR__ . "/../../conf.php"
?>
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/common/confirmation/confirmation.css">

<div id= "confirmationContainer" class="rounded shadow">
    <div id="confirmationTitle">
        A title
    </div>
    <div class="confirmationButtons">
        <button class="careButton" id="acceptConfirmationButton">Confirm</button>
        <button class="careButton" id="declineConfirmationButton">Cancel</button>
    </div>
</div>

<script src="<?= $base_url ?>/common/confirmation/confirmation.js"></script>