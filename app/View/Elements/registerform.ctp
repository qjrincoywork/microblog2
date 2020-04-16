<div class="card">
    <!-- <div class="card-header"><?= __('Sign up')?></div> -->
        <div class="card-body card-block">
            <div class="bd-note rounded">
                <p><strong>NOTE:</strong> Please type your <strong>Password</strong> having 8 characters with At least 1 uppercase letter, lowercase  letters, numbers and 1 special character</p>
            </div>
            <?= $this->Form->create('User',
                                    ['url' => 'register', 'id' => 'UserRegisterForm'],
                                    ['inputDefaults'=> ['div' => 'form-group']]); ?>
                <div class="row">
                    <div class="col-md-6">
                    <?php 
                        echo $this->Form->input('User.username',
                                            ['class' => 'form-control form-control-sm',
                                                'placeholder' => 'Enter username ...',
                                                'id' => 'username',
                                                'label'=>['text'=>'Username',
                                                        'for' => 'username',
                                                        'class'=>'col-form-label']]);
                        echo $this->Form->input('User.password',
                                            ['class' => 'form-control form-control-sm',
                                            'placeholder' => 'Enter password ...',
                                            'id' => 'password',
                                                'label'=>['text'=>'Password',
                                                        'for' => 'password',
                                                        'class'=>'col-form-label']]);
                        echo $this->Form->input('User.confirm_password',
                                            ['class' => 'form-control form-control-sm',
                                            'type'=>'password',
                                            'placeholder' => 'Enter Confirm Password ...',
                                            'id' => 'confirm_password',
                                                'label'=>['text'=>'Confirm Password',
                                                        'for' => 'confirm_password',
                                                        'class'=>'col-form-label']]);
                        $options = ['' => 'Select Gender...', 0 => 'Female', 1 => 'Male'];
                        echo $this->Form->input('UserProfile.gender',
                                                ['options' => $options,
                                                'id' => 'gender',
                                                    'class' => 'form-control form-control-sm',
                                                    'label'=>['text'=>'Gender',
                                                        'for' => 'gender',
                                                        'class'=>'col-form-label']]
                                            );
                        ?>
                        </div>
                        
                    <div class="col-md-6">
                    <?php    echo $this->Form->input('UserProfile.first_name',
                                            ['class' => 'form-control form-control-sm',
                                            'placeholder' => 'Enter first name ...',
                                            'id' => 'first_name',
                                                'label'=>['text'=>'First Name',
                                                        'for' => 'first_name',
                                                        'class'=>'col-form-label']]);
                        echo $this->Form->input('UserProfile.last_name',
                                            ['class' => 'form-control form-control-sm',
                                            'placeholder' => 'Enter last name ...',
                                            'id' => 'last_name',
                                                'label'=>['text'=>'Last name',
                                                        'for' => 'last_name',
                                                        'class'=>'col-form-label']]);
                        echo $this->Form->input('UserProfile.middle_name',
                                            ['class' => 'form-control form-control-sm',
                                            'placeholder' => 'Enter middle name ...',
                                            'id' => 'middle_name',
                                                'label'=>['text'=>'Middle Name',
                                                        'for' => 'middle_name',
                                                        'class'=>'col-form-label']]);
                        echo $this->Form->input('UserProfile.suffix',
                                            ['class' => 'form-control form-control-sm',
                                            'placeholder' => 'Enter suffix ...',
                                            'id' => 'suffix',
                                                'label'=>['text'=>'Suffix',
                                                        'for' => 'suffix',
                                                        'class'=>'col-form-label']]);
                    ?>
                    </div>
                    
                    <div class="col-md-12">
                    <?php 
                        echo $this->Form->input('UserProfile.email',
                                            ['class' => 'form-control form-control-sm',
                                            'placeholder' => 'Enter email ...',
                                            'id' => 'email',
                                                'label'=>['text'=>'Email',
                                                        'for' => 'email',
                                                        'class'=>'col-form-label']]);
                    ?>
                    </div>
                    <div class="col-md-12">
                    <?= $this->Form->end(['label' => 'register',
                                            'class' => 'register_user btn btn-primary form-control',
                                            'div' => 'form-group mt-3']); ?>
                    </div>
            </div>
            </div>
    </div>
</div>