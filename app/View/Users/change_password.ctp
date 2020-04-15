<div class="card-body card-block offset-md-3 mt-4">
    <div class="row">
        <div class="bd-note rounded">
            <p><strong>NOTE:</strong> Please type the <strong>Passwords</strong> having 8 characters with At least 1 uppercase letter, lowercase  letters, numbers and 1 special character</p>
        </div>
        <div class="col-md-8 offset-md-2">
            <?= $this->Form->create('User',
                                    ['url' => ['controller'=>'users','action'=>'changePassword']],
                                    ['inputDefaults'=> ['div' => 'form-group']]); ?>
                                    
            <?php
                echo $this->Form->input('old_password',
                                    ['class' => 'form-control form-control-sm',
                                    'type' => 'password',
                                    'placeholder' => 'Enter Old Password ...',
                                    'id' => 'old_password',
                                        'label'=>['text'=>'Old Password',
                                                'for' => 'old_password',
                                                'class'=>'col-form-label']]);
                echo $this->Form->input('password',
                                        ['class' => 'form-control form-control-sm',
                                        'type' => 'password',
                                        'placeholder' => 'Enter New Password ...',
                                        'id' => 'password',
                                            'label'=>['text'=>'New Password',
                                                    'for' => 'password',
                                                    'class'=>'col-form-label']]);
                echo $this->Form->input('confirm_password',
                                    ['class' => 'form-control form-control-sm',
                                    'type' => 'password',
                                    'placeholder' => 'Enter Confirm Password ...',
                                    'id' => 'confirm_password',
                                        'label'=>['text'=>'Confirm Password',
                                                'for' => 'confirm_password',
                                                'class'=>'col-form-label']]);
            ?>
            <?= $this->Form->end(['label' => 'Change Password',
                                    'type' => 'button',
                                    'class' => 'change_password form-control btn btn-primary mt-5',
                                    'style' => 'float: right']); 
            ?>
        </div>
    </div>
</div>