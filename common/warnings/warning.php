<?php
    include_once __DIR__ . "/../../conf.php"
?>
<link rel="stylesheet" type="text/css" href="<?= $base_url ?>/common/warnings/warning.css">

<div id= "warningContainer" class="rounded shadow">
    <div id="warningTitle">
        A title
    </div>
    <div class="warningButtons">
        <button class="careButton" id="acceptWarningButton">Okay</button>
       
    </div>
</div>

<script src="<?= $base_url ?>/common/warnings/warning.js"></script>