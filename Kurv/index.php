<?php
    ob_start();
    session_start();
    require_once 'classes/Basket.class.php';
    $minKurv = new Basket();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body{
            background-color: beige;
        }
        *{
            margin: 0;
            padding: 0;
        }
        h3{
            background-color: cornflowerblue;
            color: white;
            text-shadow: 1px 1px 5px #000;
            line-height: 50px;
            padding: 0 15px;
        }
        form{
            margin: 0 15px;
        }
        pre{
            background-color: slategray;
            color: white;
            text-shadow: 1px 1px 5px #000;
        }
    </style>
</head>
<body>

    <h3>Ny varer i kurv</h3>
    <pre>
        <code>
        $minKurv->PutIKurv(99, 3, 50, 'Sammy');
        </code>
    </pre>
    <?php
        //$minKurv->PutIKurv(99, 3, 50, 'Sammy');
        //$minKurv->PutIKurv(9, 1, 5, 'adl');
    ?>

    <h3>Vis kurv</h3>
    <pre>
        <code>
        foreach ($minKurv->VisKurv() as $key => $value){
            echo $key;
            echo $value['navn'];
            echo $value['pris'];
            echo $value['antal'];
        }
        </code>
    </pre>
    <?php
        foreach ($minKurv->VisKurv() as $key => $value){
            echo 'Produkt id : ' . $key . '<br />';
            echo 'Navn : ' . $value['navn'] . '<br />';
            echo 'Pris : ' . $value['pris'] . '<br />';
            echo 'Antal : ' . $value['antal'] . '<br />' . '<br />';
        }
    ?>
    <h3>Tilføj en til</h3>
    <pre>
        <code>
        if(isset($_GET['add'])){
            $minKurv->RetVare($_GET['add'], 1);
            header('Location: index.php');
        }
        </code>
    </pre>
    <?php
        if(isset($_GET['add'])){
            $minKurv->RetVare($_GET['add'], 1);
            header('Location: index.php');
        }

        foreach ($minKurv->VisKurv() as $key => $value){
            echo 'Produkt id : ' . $key . '<br />';
            echo 'Navn : ' . $value['navn'] . '<br />';
            echo 'Pris : ' . $value['pris'] . '<br />';
            echo 'Antal : ' . $value['antal'] . '<br />' . '<br />';
            echo '<a href="index.php?add='.$key.'">Tilføj</a><br /><br />';
        }
    ?>
    <h3>Fjern en fra</h3>
    <pre>
        <code>
        if(isset($_GET['minus'])){
            $minKurv->MinusVare($_GET['minus'], 1);
            header('Location: index.php');
        }
        </code>
    </pre>
    <?php
    if(isset($_GET['minus'])){
        $minKurv->MinusVare($_GET['minus'], 1);
        header('Location: index.php');
    }

    foreach ($minKurv->VisKurv() as $key => $value){
        echo 'Produkt id : ' . $key . '<br />';
        echo 'Navn : ' . $value['navn'] . '<br />';
        echo 'Pris : ' . $value['pris'] . '<br />';
        echo 'Antal : ' . $value['antal'] . '<br />' . '<br />';
        echo '<a href="index.php?minus='.$key.'">Fjern en fra</a><br /><br />';
    }
    ?>
    <h3>Slet en vare</h3>
    <pre>
        <code>
        if(isset($_GET['remove'])){
            $minKurv->SletVare($_GET['remove'], 1);
            header('Location: index.php');
        }
        </code>
    </pre>
    <?php
    if(isset($_GET['remove'])){
        $minKurv->SletVare($_GET['remove']);
        header('Location: index.php');
    }

    foreach ($minKurv->VisKurv() as $key => $value){
        echo 'Produkt id : ' . $key . '<br />';
        echo 'Navn : ' . $value['navn'] . '<br />';
        echo 'Pris : ' . $value['pris'] . '<br />';
        echo 'Antal : ' . $value['antal'] . '<br />' . '<br />';
        echo '<a href="index.php?remove='.$key.'">Fjern vare</a><br /><br />';
    }
    ?>

    <h3>Afslut handel</h3>
    <pre>
        <code>
        if(isset($_POST['checkout'])){
            echo 'Din ordre er modtaget.';
            $minKurv->Afslut();
        }
        </code>
    </pre>
    <?php
        if(isset($_POST['checkout'])){
            echo 'Din ordre er modtaget.';
            $minKurv->Afslut();
        }
    ?>
    <form method="post" action="">
        Navn:<br>
        <input type="text" name="fullname"><br>
        Adresse:<br>
        <input type="text" name="address"><br>
        <button type="submit" name="checkout">Køb</button>
    </form>
</body>
</html>