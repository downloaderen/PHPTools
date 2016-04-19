<?php
/**
 * Created by PhpStorm.
 * User: lilto
 * Date: 19-04-2016
 * Time: 13:22
 */

ob_start();

spl_autoload_register(function ($class) {
    require_once dirname(__FILE__) . '/classes/'. $class . '.php';
});

$router = new Router();
$router->Folder = 'pages';
$router->DefaultPage = 'home';
$router->PredefinedPages = array(
    'home' => 'home',
    'something' => 'test',
    'dude' => 'subfolder/subsite'
);
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
            <li><a href="index2.php?p=home">Home</a></li>
            <li><a href="index2.php?p=something">Test</a></li>
            <li><a href="index2.php?p=dude">Subsite</a></li>
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
