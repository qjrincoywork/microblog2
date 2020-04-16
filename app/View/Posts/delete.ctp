<div class='card-body card-block mt-3'>
    <label for='nf-description' class='form-control-label'>Are you sure you wish to <?= $this->data['Post']['deleted'] ? "restore" : "delete" ?> this post?</label>
</div>
<?= $this->Form->create('Post',
                        ['url' => ['controller' =>'posts', 'action' => 'delete']],
                        ['inputDefaults'=> ['div' => 'form-group']]); ?>
<?php
    $label = $this->data['Post']['deleted'] ? "Restore" : "Delete";
    $classListener = $this->data['Post']['deleted'] ? "restore_post" : "delete_post";
    $value = $this->data['Post']['deleted'] ? 0 : 1;
    
    echo $this->Form->input('id', array(
                            'label' => false,
                            'type' => 'hidden',
                            'id' => 'id'
    ));

    echo $this->Form->input('deleted', array(
                            'label' => false,
                            'id' => 'deleted',
                            'type' => 'hidden',
                            'value' => $value,
                            'class' => 'mb-3 form-control '
    ));
?>
<?= $this->Form->end(['label' => $label,
                      'class' => $classListener.' btn btn-primary form',
                      'div' => 'form-group mt-3',
                      'style' => 'float: right']); ?>