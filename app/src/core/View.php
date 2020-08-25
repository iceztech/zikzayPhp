<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/6/2020
 *Time: 3:40 PM
 */

namespace Zikzay\Core;

use Zikzay\core\abstracts\Display;

class View extends Display
{
    protected $_site_title = SITE_TITLE, $_layout = DEFAULT_LAYOUT;

    public function __construct($page = '', $params = '')
    {
        $this->render($page, $params);
    }

    public function render($view, $data) {

        if(is_array($data) || is_object($data)){
            foreach ($data as $key => $datum) {
                $$key = $datum;
            }
        } else {
            $$data = $data;
        }


        $viewPath = explode('/', $view);
        $view = implode(DS, $viewPath);

        include VIEWS_PATH . DS . $view . '.php';
        parent::formError();

    }



}