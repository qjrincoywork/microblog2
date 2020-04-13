<div class="border mt-3">
    <div class="post-form-container container pt-3">
        <?= $this->Form->create('Post',
                                ['url' => ['controller' =>'posts', 'action' => 'add']],
                                ['inputDefaults'=> ['div' => 'form-group']]); ?>
        <?php
            echo $this->Form->input('content', [
                                    'label' => false,
                                    'id' => 'content',
                                    'class' => 'form-control',
                                    'placeholder' => "What's happening?..."
            ]);
        ?>
        <div class="preview-image border mt-2" id="preview-image">
            
        </div>
        <?= $this->Form->input('image',
                            ['label' => false,
                            'class' => 'add_image_input',
                            "accept" => ".jpeg, .jpg, .png, .gif",
                            'id' => 'image',
                            'style' => 'display: none;',
                            'type' => 'file']);?>
                            
        <button class="preview_image far fa-image mt-3" data-toggle='tooltip' data-placement='top' title='add image' style="float: left; font-size: 30px; color: #4c82a3;">
        </button>
        <?= $this->Form->input('Post',
                                ['class' => 'post_content btn btn-primary mt-3',
                                'label' => false,
                                'type' => 'submit',
                                'style' => 'float: right']);?>
        <?= $this->Form->end();?>
    </div>
</div>