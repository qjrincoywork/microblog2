<div class="col-md-6 offset-md-6">
    <?= $this->Form->create('User', ['class' => 'form-inline', 
                                            'inputDefaults'=> ['div' => 'form-group']]); ?>
    <div class="row">
        <?= $this->Form->input('log_username',
                            ['class' => 'form-control form-control-sm',
                                'placeholder' => 'Enter username ...',
                                'label'=>['text'=>'Username',
                                        'for' => 'log_username',
                                        'class'=>'col-form-label']
                            ]); ?>
        <?= $this->Form->input('log_password',
                            ['class' => 'form-control form-control-sm',
                                'placeholder' => 'Enter password ...',
                                'type' => 'password',
                                'label'=>['text'=>'Password',
                                        'for' => 'log_password',
                                        'class'=>'col-form-label']]);?>
        <?= $this->Form->end(['label' => 'login',
                            'class' => 'btn btn-secondary btn-sm',
                            'div' => 'form-group']); ?>
    </div>
</div>