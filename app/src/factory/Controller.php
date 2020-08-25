<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 8/4/2020
 *Time: 4:22 PM
 */

namespace Zikzay\factory;



use Zikzay\Lib\Util;

class Controller
{
    public function __construct($args)
    {
        if(empty($args)) {
            echo EL;
            echo "Enter Controller option (create/push):".EL.">> ";
            $line = fgets(STDIN, 32);

            $this->make($line);

        } else {
            $this->make($args);
        }
    }

    private function make($options)
    {
        if(!is_array($options)) {
            $options = explode(' ', $options);
        }
        if(trim($options[0]) == 'create') {

            if(isset($options[1])) {
                $this->create(ucwords(trim($options[1])).'Controller');
            }else {
                echo EL;
                echo "Enter the name of the Controller to create:".EL.">> ";
                $line = fgets(STDIN, 32);

                $this->create(ucwords(trim($line)).'Controller');
            }

        } else if($options[0] == 'push') {

            echo EL;
            echo "Enter Model option (create/push)2:".EL.">> ";
            $line = fgets(STDIN, 32);
        }

    }



    public function create($name) {
        $path = CONTROLLERS_PATH . DS . $name . '.php';
        $model = str_replace('Controller', '', $name);
        $resp = file_put_contents($path, $this->modelFrame($name, $model));

        $message = $resp ? 'Creating Controller - '. $name : 'An error occur while creating Model: ' . $name;
        Util::cmdPrint($message, 1);
    }

    private function modelFrame($name, $model){
        return (
            '<?php
namespace Zikzay\Controller;


use Zikzay\Core\Controller;
use Zikzay\Core\View;
use Zikzay\Model\\' .$name.';

class ' .$name.' extends Controller
{

    public function __construct()
    {
        //TODO: Handle authentication here
        //TODO:NCreate an alias for namespace to make class call very easy

    }

    public function index ($params) 
    {
        new View("pages/index", $params);

    }
    public function create($params) 
    {
        $' .strtolower($model).' = new ' .$model.'();

         ' .$model.'::$data = $this->getRequest($' .strtolower($model).');

        $'.strtolower($model).'->save();

        //header("location: /");
    }

}');
    }
}