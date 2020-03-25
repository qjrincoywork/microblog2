<?php
    if(!isset($params['escape']) || $params['escape'] !== false) {
        $message = h($message);
    }
?>
<div class="alert alert-success" id="flashMessage" onclick="this.classList.add('hidden');"><?= $message ?></div>