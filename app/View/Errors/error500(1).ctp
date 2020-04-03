<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>404 HTML Template by Colorlib</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,700" rel="stylesheet">

    <?= $this->Html->css('error/style500');?>
</head>

<body>
    <?= $this->layout = null;?>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <?php
                    $actual_link = (isset($_SERVER['HTTPS']) === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                ?>
                <h1>ERROR!</h1>
                <h2>An Internal Error Has Occurred.</h2>
            </div>
            <a href="<?= $actual_link ?>">Go TO Homepage</a>
        </div>
    </div>
    <h2><?php 
    /* echo $message; */ ?></h2>
    <p class="error">
        <strong><?php /* echo __d('cake', 'Error'); */ ?> </strong>
        <?php /* printf(
            __d('cake', 'The requested address %s was not found on this server.'),
            "<strong>'{$url}'</strong>"
        ); */ ?>
    </p>
</body>

</html>