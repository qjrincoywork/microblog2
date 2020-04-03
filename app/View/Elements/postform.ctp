<div class="post-form-container container pt-3">
    <?= $this->Form->create('Post',
                            ['url' => ['controller' =>'posts', 'action' => 'add']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
    <?php
        echo $this->Form->input('content', array(
                                'label' => false,
                                'id' => 'content',
                                'class' => 'form-control',
                                'placeholder' => "What's happening?..."
        ));
    ?>
    <?= $this->Form->end(['label' => 'Post',
                            'class' => 'post_content btn btn-primary form',
                            'div' => 'form-group mt-3',
                            'style' => 'float: right']); ?>
</div>