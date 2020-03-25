<!DOCTYPE html>
<html>
    <head>		
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
            echo $this->Html->css('font-face');
            echo $this->Html->css('all.min');
            echo $this->Html->css('fontawesome.min');

            echo $this->Html->css('material-design-iconic-font.min');
            echo $this->Html->css('fonts');
            
            echo $this->Html->css('bootstrap.min');
            echo $this->Html->css('animsition.min');
            echo $this->Html->css('perfect-scrollbar');

            echo $this->Html->css('simplebar');
            echo $this->Html->css('app');
            echo $this->Html->css('theme');
            echo $this->Html->css('style');
        ?>
    </head>
<body>
	<?php echo $this->element('sidebar'); ?>
	
    <div class="page-container">
        <?php echo $this->element('header'); ?>
	
        <div class="main-content" style=" height: 100%;">
            <div class="section__content section__content--p30">
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>

    <div id="footer">
        <?= $this->Html->script('jquery-3.2.1.min'); ?>
        <?= $this->Html->script('bootstrap.min'); ?>
        <?= $this->Html->script('animsition.min'); ?>
        <?= $this->Html->script('perfect-scrollbar'); ?>

        <?= $this->Html->script('simplebar'); ?>
        <?= $this->Html->script('main'); ?>
        <?= $this->Html->script('app-layout'); ?>
    </div>
</body>
</html>
