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
                </nav>
            </div>
            <div id="content">
                <?= $this->Flash->render(); ?>
                <?= $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <?= $this->Html->script('jquery-3.2.1.min'); ?>
                <?= $this->Html->script('jquery-ui.min'); ?>
                <?= $this->Html->script('bootstrap-notify.min'); ?>
                <?= $this->Html->script('app-layout'); ?>
                <?= $this->Html->script('auth-scripts'); ?>
            </div>
        </div>
    </body>
</html>
