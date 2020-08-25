<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/23/2020
 *Time: 8:11 PM
 */

namespace Zikzay\Core;

use Zikzay\http\Request;

class Controller
{
    protected $controller, $method;
    public $view;
    protected $request;


    public function __construct($controller = '', $method = '')
    {

        //TODO: Handle data or parameters posted to any controller

//        parent::__construct();
//        $this->_controller = $controller;
//        $this->_action = $action;
//        $this->view = new View();
    }

    protected function load_model($model) {
        if(class_exists($model)) {
            $this->{$model.'Model'} = new $model(strtolower($model));
        }
    }


    public function getRequest($model) : array
    {
        $this->request = Request::request($model);

        return $this->request;
    }

}