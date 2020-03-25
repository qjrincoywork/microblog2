<?php
    if(!isset($params['escape']) || $params['escape'] !== false) {
        $message = h($message);
    }
?>
<div class="alert alert-danger" id="flashMessage" onclick="this.classList.add('hidden');"><?= $message ?></div>