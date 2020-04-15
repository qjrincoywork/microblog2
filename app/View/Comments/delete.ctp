<div class='card-body card-block mt-3'>
    <label for='nf-description' class='form-control-label'>Are you sure you wish to <?= $data['Comment']['deleted'] ? "restore" : "delete" ?> this comment?</label>
</div>
<?= $this->Form->create('Comment',
                        ['url' => ['controller' =>'comments', 'action' => 'delete']],
                        ['inputDefaults'=> ['div' => 'form-group']]); ?>
<?php
    $label = $data['Comment']['deleted'] ? "Restore" : "Delete";
    $value = $data['Comment']['deleted'] ? 0 : 1;
    $classListener = $data['Comment']['deleted'] ? "restore_comment" : "delete_comment";
    $id = $data['Comment']['id'];

    echo $this->Form->input('id', array(
                            'label' => false,
                            'type' => 'hidden',
                            'value' => $id,
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