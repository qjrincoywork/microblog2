<?php
    $id = $data['Comment']['id'];
    $content = $data['Comment']['content'];
?>
<div class="container p-3">
    <?= $this->Form->create('Comment',
                            ['url' => ['controller' =>'comments', 'action' => 'edit']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
    <?php
        echo $this->Form->input('content', array(
                                'label' => false,
                                'id' => 'content',
                                'type' => 'text',
                                'value' => $data['Comment']['content'],
                                'class' => 'mb-3 form-control ',
                                'placeholder' => "Edit Content..."
        ));
        echo $this->Form->input('id', array(
                                'label' => false,
                                'type' => 'hidden',
                                'value' => $id,
                                'id' => 'id'
        ));
    ?>
    <?= $this->Form->end(['label' => 'edit comment',
                            'class' => 'edit_comment btn btn-primary',
                            'div' => 'form-group mt-3',
                            'style' => 'float: right']); ?>
</div>