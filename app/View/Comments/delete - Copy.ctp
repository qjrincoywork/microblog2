<div class='card-body card-block mt-3'>
    <label for='nf-description' class='form-control-label'>Are you sure you wish to delete this comment?, 
        This can't be undone and it will be removed from your profile and the timeline of any accounts.</label>
</div>
<?= $this->Form->create('Comment',
                        ['url' => ['controller' =>'comments', 'action' => 'delete']],
                        ['inputDefaults'=> ['div' => 'form-group']]); ?>
<?php
    $id = $data['Comment']['id'];

    echo $this->Form->input('id', array(
                            'label' => false,
                            'type' => 'hidden',
                            'value' => $id,
                            'id' => 'id'
    ));
?>
<?= $this->Form->end(['label' => 'Remove',
                      'class' => 'delete_comment btn btn-danger',
                      'div' => 'form-group mt-3',
                      'style' => 'float: right']); ?>