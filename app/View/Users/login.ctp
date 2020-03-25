<div class="container pt-4">
	<?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-md-6">
            <p>
                <h1><center> Microblog 2 </center></h1>
            </p>
            <p>
                Praesent tincidunt dictum aliquet. Aliquam dapibus dui felis, dictum ullamcorper sapien malesuada vel. Duis suscipit felis sit amet massa posuere dapibus. Vivamus nec quam nunc. Vestibulum finibus libero sed nisl luctus consequat. Vestibulum eget magna nec augue pellentesque vehicula quis vitae mi. Vivamus quis dignissim lacus. Duis est nibh, luctus et mauris accumsan, pulvinar tempus enim. Mauris vitae pellentesque dui, sit amet tristique arcu. Vivamus lacus diam, molestie eget orci non, pulvinar luctus felis. Nullam et sagittis ante. In tortor lectus, volutpat at pharetra vel, accumsan sed libero.
            </p>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><?= __('Register')?></div>
                    <div class="card-body card-block">
                        <?= $this->Form->create('User',
                                                ['url' => 'register'],
                                                ['inputDefaults'=> ['div' => 'form-group']]); ?>
                            <div class="row">
                                <div class="col-md-6">
                                <?php 
                                    echo $this->Form->input('username',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter username ...',
                                                            'label'=>['text'=>'Username',
                                                                    'for' => 'username',
                                                                    'class'=>'col-form-label']]);
                                    echo $this->Form->input('password',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter password ...',
                                                            'label'=>['text'=>'Password',
                                                                    'for' => 'password',
                                                                    'class'=>'col-form-label']]);
                                    echo $this->Form->input('email',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter email ...',
                                                            'label'=>['text'=>'Email',
                                                                    'for' => 'email',
                                                                    'class'=>'col-form-label']]);

                                    $options = ['' => 'Select Gender...', 0 => 'Female', 1 => 'Male'];
                                    echo $this->Form->input('gender',
                                                            ['options' => $options,
                                                                'class' => 'form-control form-control-sm',
                                                                'label'=>['text'=>'Gender',
                                                                    'for' => 'gender',
                                                                    'class'=>'col-form-label']]
                                                        );
                                    ?>
                                    </div>
                                    
                                <div class="col-md-6">
                                <?php    echo $this->Form->input('first_name',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter first name ...',
                                                            'label'=>['text'=>'First Name',
                                                                    'for' => 'first_name',
                                                                    'class'=>'col-form-label']]);
                                    echo $this->Form->input('last_name',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter last name ...',
                                                            'label'=>['text'=>'Last name',
                                                                    'for' => 'last_name',
                                                                    'class'=>'col-form-label']]);
                                    echo $this->Form->input('middle_name',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter middle name ...',
                                                            'label'=>['text'=>'Middle Name',
                                                                    'for' => 'middle_name',
                                                                    'class'=>'col-form-label']]);
                                    echo $this->Form->input('suffix',
                                                        ['class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Enter suffix ...',
                                                            'label'=>['text'=>'Suffix',
                                                                    'for' => 'suffix',
                                                                    'class'=>'col-form-label']]);
                                ?>
                                </div>
                                
                                <div class="col-md-12">
                                <?= $this->Form->end(['label' => 'register',
                                                    'class' => 'btn btn-primary form-control',
                                                    'div' => 'form-group mt-3']); ?>
                                </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>