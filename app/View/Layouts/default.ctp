<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php //echo $cakeDescription ?>
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
            echo $this->Html->meta('icon');

            // echo $this->Html->css('cake.generic');
            echo $this->Html->css('font-face');
            echo $this->Html->css('all.min');
            echo $this->Html->css('fontawesome.min');

            echo $this->Html->css('material-design-iconic-font.min');
            echo $this->Html->css('fonts');
            
            echo $this->Html->css('bootstrap.min');
            echo $this->Html->css('app');

            // echo $this->fetch('meta');
            // echo $this->fetch('css');
            // echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <nav class="navbar navbar-light bg-secondary">
                    <!-- Navbar content -->
                    <div class="col-md-6 offset-md-6">
                        <?= $this->Flash->render('auth'); ?>
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
                                                'class' => 'btn btn-primary btn-sm',
                                                'div' => 'form-group']); ?>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="content">
                <?= $this->Flash->render(); ?>
                <?= $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <?= $this->Html->script('jquery-3.2.1.min'); ?>
                <?= $this->Html->script('auth-scripts'); ?>
            </div>
        </div>
    </body>
</html>
