<?php
    /* pr($data);
    die('view'); */
?>

<div class="card-body card-block mt-2">
    <?= $this->Form->create('User',
                            ['url' => ['controller'=>'users','action'=>'changePassword']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
                            
    <?= $this->Form->input('id', [
                            'label' => false,
                            'type' => 'hidden',
                            'value' => $data['User']['id'],
                            'id' => 'id']);
    ?>

    <?= $this->Form->end(['label' => 'Change Password',
                            'type' => 'button',
                            'class' => 'btn btn-primary mt-5',
                            'style' => 'float: right']); 
    ?>
</div>