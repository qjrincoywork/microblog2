
<div class="alert alert-success" onclick="this.classList.add('hidden');">
    <h3>Your email has been verified, please login now</h3>
    <?php
        echo $this->Html->link("Login here", ['action' => 'login']);
    ?>
</div>