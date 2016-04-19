<?php

/**
 * Created by PhpStorm.
 * User: lilto
 * Date: 19-04-2016
 * Time: 08:14
 */
class Router
{
    public $Folder;
    public $DefaultPage;
    private $Content = null;

    public function getContent()
    {
        if($this->Content != null) {
            return $this->Content;
        }
    }

    public function Router()
    {

    }

    public function init($urlParam = 'p'){
        if(isset($_GET[$urlParam])){
            $file = $this->Folder . '/' . $_GET[$urlParam] . '.php';
            if(file_exists($file)){
                $this->Content = file_get_contents($file);
            } else {
                http_response_code(404);
                //header('HTTP/1.0 404 Not Found', true, 404);
            }
        } else {
            header('Location: index.php?' . $urlParam . '=' . $this->DefaultPage);
        }
    }
}