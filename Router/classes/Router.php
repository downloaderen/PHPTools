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
    private $FilePath = null;
    public $PredefinedPages = array();

    public function getContent()
    {
        if($this->Content != null) {
            return $this->Content;
        }
    }

    public function getFilePath()
    {
        if($this->FilePath != null) {
            return $this->FilePath;
        }
    }

    public function Router()
    {

    }

    private function FindPageFromPredefined($search){
        foreach ($this->PredefinedPages as $key => $value){
            if($key == $search){
                return true;
            }
        }
    }

    public function init($urlParam = 'p'){
        if(isset($_GET[$urlParam])){
            $urlParameter = $_GET[$urlParam];
            if($this->FindPageFromPredefined($_GET[$urlParam])) {
                $filename = $this->PredefinedPages[$urlParameter];
                $file = $this->Folder . '/' . $filename . '.php';
                if (file_exists($file)) {
                    $this->Content = file_get_contents($file);
                    $this->FilePath = $file;
                } else {
                    http_response_code(404);
                    //header('HTTP/1.0 404 Not Found', true, 404);
                }
            } else{
                $file = $this->Folder . '/' . $_GET[$urlParam] . '.php';
                if (file_exists($file)) {
                    $this->Content = file_get_contents($file);
                    $this->FilePath = $this->Folder . '/' . $_GET[$urlParam] . '.php';
                } else {
                    http_response_code(404);
                    //header('HTTP/1.0 404 Not Found', true, 404);
                }
            }
        } else {
            header('Location: ?' . $urlParam . '=' . $this->DefaultPage);
        }
    }
}