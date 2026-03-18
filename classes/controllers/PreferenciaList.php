<?php 
require_once __DIR__ . '/../models/Preferencia.php';

class PreferenciaList {
    private $html;

    public function __construct(){
        $this->html = file_get_contents(__DIR__ . '/../../html/preferencias/list.html');
    }
    
    public function delete($param){
        try {
            $id = $param['id'];
            Preferencia::delete($id);
        } catch(Exception $e){
            print $e->getMessage();
        }
    }

    public function load(){
        try {
            $preferencias = Preferencia::all();
            $items = '';

            $itemTemplate = file_get_contents(__DIR__ . '/../../html/preferencias/item.html');

            foreach($preferencias as $preferencia){
                $item = $itemTemplate;

                foreach($preferencia as $key => $value){
                    $item = str_replace('{' . $key . '}', htmlspecialchars($value ?? ''), $item);
                }

                $items .= $item;
            }

            $this->html = str_replace('{items}', $items, $this->html);

        } catch(Exception $e){
            print $e->getMessage();
        }
    }

    public function show(){
        $this->load();
        print $this->html;
    }
}