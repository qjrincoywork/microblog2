<div class="card-body card-block mt-2">
    <?= $this->Form->create('UserProfile',
                            ['enctype' => 'multipart/form-data'],
                            ['url' => ['controller'=>'users','action'=>'editPicture']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
                            
    <?= $this->Form->input('id', [
                            'label' => false,
                            'type' => 'hidden',
                            'value' => $data['UserProfile']['id'],
                            'id' => 'id']);
    ?>
                            
    <?= $this->Form->input('image',
                        ['class' => 'form-control',
                        'id' => 'image',
                        'type' => 'file',
                        'value' => $data['UserProfile']['image'],
                            'label'=>['text'=>'Upload Image',
                                    'for' => 'image',
                                    'class'=>'col-form-label']]);?>

    <?= $this->Form->end(['label' => 'edit picture',
                            'type' => 'button',
                            'class' => 'update_picture btn btn-primary mt-5',
                            'style' => 'float: right']); 
    ?>
</div>