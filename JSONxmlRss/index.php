<?php
    spl_autoload_register(function ($class) {
        include '\\classes\\'. $class . '.php';
    });

    $db = new DB('localhost','cmk_php_nyhedssite');

    class API{
        public function createJSON($arr){
            $name = new stdClass;
            foreach($arr as $key => $value){
                $name->$key = $value;
            }
            header('Content-Type: application/json');
            return json_encode($name, JSON_FORCE_OBJECT);
            //return $name;
        }
        private function array_to_XML(array $arr, SimpleXMLElement $xml){
            foreach ($arr as $key => $value) {
                if(is_array($value)){
                    if(is_int($key)){
                        if(!is_array(current($value))){
                            // echo '<pre>' , print_r($value), '</pre>';
                            $this->array_to_XML($value, $xml->addChild('item'));
                        } else {
                            $this->array_to_XML($value[array_keys($value)[0]], $xml->addChild(array_keys($value)[0]));
                        }
                    } else {
                        $this->array_to_XML($value, $xml->addChild($key));
                    }
                } else {
                    $xml->addChild($key, $value);
                }
            }
            return $xml;
        }
        public function createXML($arr, $root = '<root/>'){
            header('Content-Type: application/xml');
            return $this->array_to_XML($arr, new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>'.$root))->asXML();
        }
    }
    $category_id = 1;
    $category = $db->Single('SELECT * FROM categories WHERE category_id = :id', array(':id' => $category_id));

    $ultra = new API();
    $arr = array(
        'channel' => array(
            'id' => $category->category_id,
            'title' => $category->category_title,
            'description' => $category->category_description
        )
    );

    $allNews = $db->ToList('SELECT news_id, news_title, news_content, news_postdate, category_id, category_title
                FROM news
                INNER JOIN categories ON category_id = news.fk_categories_id
                WHERE category_id = :id ORDER BY news_postdate DESC', array(':id' => $category_id));

    foreach($allNews as $value)
    {
        $arr['channel'][] = array(
            'title' => $value->news_title,
            'description' => htmlentities($value->news_content)
        );
    }

    echo $ultra->createXML($arr, '<rss/>');


?>