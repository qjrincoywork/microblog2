<div class="card-body card-block mt-2">
    <?= $this->Form->create('UserProfile',
                            ['url' => ['controller'=>'users','action'=>'edit']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
    <?php
        // echo $this->Form->unlockField('UserProfile.id');
        
        /* echo $this->Form->input('UserProfile.id',
                            ['class' => 'form-control',
                            'type' => 'hidden',
                            'id' => 'id',
                            'value' => $data['UserProfile']['id']]); */
        echo $this->Form->input('UserProfile.email',
                            ['class' => 'form-control',
                            'placeholder' => 'Enter email ...',
                            'id' => 'email',
                            'value' => $data['UserProfile']['email'],
                                'label'=>['text'=>'Email',
                                        'for' => 'email',
                                        'class'=>'col-form-label']]);
        
        $options = ['' => 'Select Gender...', 0 => 'Female', 1 => 'Male'];
        echo $this->Form->input('UserProfile.gender',
                                ['options' => $options,
                                'selected' => $data['UserProfile']['gender'],
                                'id' => 'gender',
                                    'class' => 'form-control',
                                    'label'=>['text'=>'Gender',
                                        'for' => 'gender',
                                        'class'=>'col-form-label']]
        );
        ?>
        
    <?php
        echo $this->Form->input('UserProfile.first_name',
                                ['class' => 'form-control',
                                'placeholder' => 'Enter first name ...',
                                'id' => 'first_name',
                                'value' => $data['UserProfile']['first_name'],
                                'label'=>['text'=>'First Name',
                                        'for' => 'first_name',
                                        'class'=>'col-form-label']]);
        echo $this->Form->input('UserProfile.last_name',
                            ['class' => 'form-control',
                            'placeholder' => 'Enter last name ...',
                            'id' => 'last_name',
                            'value' => $data['UserProfile']['last_name'],
                                'label'=>['text'=>'Last name',
                                        'for' => 'last_name',
                                        'class'=>'col-form-label']]);
        echo $this->Form->input('UserProfile.middle_name',
                            ['class' => 'form-control',
                            'placeholder' => 'Enter middle name ...',
                            'value' => $data['UserProfile']['middle_name'],
                            'id' => 'middle_name',
                                'label'=>['text'=>'Middle Name',
                                        'for' => 'middle_name',
                                        'class'=>'col-form-label']]);
        echo $this->Form->input('UserProfile.suffix',
                            ['class' => 'form-control',
                            'placeholder' => 'Enter suffix ...',
                            'value' => $data['UserProfile']['suffix'],
                            'id' => 'suffix',
                                'label'=>['text'=>'Suffix',
                                        'for' => 'suffix',
                                        'class'=>'col-form-label']]);
    ?>
    
    <?= $this->Form->end(['label' => 'edit profile',
                            'type' => 'button',
                            'class' => 'edit_profile btn btn-primary mt-5',
                            'style' => 'float: right']); 
    ?>
</div>