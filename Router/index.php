<?php
/**
 * Created by PhpStorm.
 * User: lilto
 * Date: 19-04-2016
 * Time: 08:15
 */

ob_start();

spl_autoload_register(function ($class) {
    require_once dirname(__FILE__) . '/classes/'. $class . '.php';
});

$router = new Router();
$router->Folder = 'pages';
$router->DefaultPage = 'home';
$router->init();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="?p=home">Home</a></li>
                <li><a href="?p=test">Test</a></li>
            </ul>
        </nav>
    </header>
    <article>
        <?php
            if($router->getFilePath() != null) {
                include_once($router->getFilePath());
            }
        ?>
    </article>
    <footer>
    </footer>
</body>
</html>
