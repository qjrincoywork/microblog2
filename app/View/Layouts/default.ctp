<!DOCTYPE htm>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <link rel="icon" href="/img/microMinilogo.png">
        <title>
            <?php echo $this->fetch('title'); ?>
        </title>
        <?= $this->Html->css(['font-face', 'all.min', 'fontawesome.min', 
                                   'material-design-iconic-font.min','fonts', 'bootstrap.min', 'app'
            ]);?>
    </head>
    <body>
        <div class="page-container">
            <header class="header-desktop">
                <?php echo $this->element('loginform'); ?>
            </header>
            <div id="content">
                <?= $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <?= $this->Html->script(['jquery-3.2.1.min', 'jquery-ui.min',
                                         'bootstrap-notify.min','app-layout', 'auth-scripts'
                ]); ?>
            </div>
        </div>
    </body>
</html>