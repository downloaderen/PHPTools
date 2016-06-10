<?php
    spl_autoload_register(function ($class) {
        include '\\classes\\'. $class . '.php';
    });

    $db = new DB('localhost','cmk_php_nyhedssite');

    class UltraDynamic{
        public function createJSON($arr){
            $name = new stdClass;
            foreach($arr as $key => $value){
                $name->$key = $value;
            }
            return json_encode($name, JSON_FORCE_OBJECT);
            //return $name;
        }
        private function array_to_RSS(array $arr, SimpleXMLElement $xml)
        {
            foreach ($arr as $key => $value) {
                if(is_array($value)){
                    if(is_int($key)){
                        //echo '<pre>' , print_r($value), '</pre>';
                        $this->array_to_RSS($value['item'], $xml->addChild('item'));
                    } else {
                        $this->array_to_RSS($value, $xml->addChild($key));
                    }
                } else {
                    $xml->addChild($key, $value);
                }
            }
            return $xml;
        }
        public function createRSS($arr){
            return $this->array_to_RSS($arr, new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rss/>'))->asXML();
        }
    }
    $category_id = 1;
    $category = $db->Single('SELECT * FROM categories WHERE category_id = :id', array(':id' => $category_id));

    $ultra = new UltraDynamic();
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
        $arr['channel'][]['item'] = array(
            'title' => $value->news_title,
            'description' => htmlentities($value->news_content)
        );
    }

    //echo '<pre>', print_r($ultra->createJSON($arr));

    // header('Content-Type: application/xml');
    // echo $ultra->createRSS($arr);
    // $ultra->createXML($arr)->asXML('feeds/name.xml');
    //print $ultra->createXML($arr)->asXML();
    header('Content-Type: application/json');
    echo $ultra->createJSON($arr);


?>