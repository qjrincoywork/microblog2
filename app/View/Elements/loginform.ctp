<div class="col-md-6 offset-md-6">
    <?= $this->Form->create('User', ['class' => 'form-inline', 
                                            'inputDefaults'=> ['div' => 'form-group']]); ?>
    <div class="row">
        <?= $this->Form->input('username',
                            ['class' => 'form-control form-control-sm',
                                'placeholder' => 'Enter username ...',
                                'label'=>['text'=>'Username',
                                        'for' => 'username',
                                        'class'=>'col-form-label']
                            ]); ?>
        <?= $this->Form->input('password',
                            ['class' => 'form-control form-control-sm',
                                'placeholder' => 'Enter password ...',
                                'type' => 'password',
                                'label'=>['text'=>'Password',
                                        'for' => 'password',
                                        'class'=>'col-form-label']]);?>
        
        <?= $this->Form->end(['label' => 'login',
                             'type' => 'submit',
                            'class' => 'btn btn-secondary btn-sm',
                            'div' => 'form-group']); ?>
    </div>
</div>