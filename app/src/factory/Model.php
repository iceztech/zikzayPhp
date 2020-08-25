<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 8/4/2020
 *Time: 4:22 PM
 */

namespace Zikzay\factory;



use Zikzay\Lib\Util;

class Model
{
    public function __construct($args)
    {
        if(empty($args)) {
            echo EL;
            echo "Enter Model option (create/push):".EL.">> ";
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
                $this->create(ucwords(trim($options[1])));
            }else {
                echo EL;
                echo "Enter the name of the Model to create:".EL.">> ";
                $line = fgets(STDIN, 32);

                $this->create(ucwords(trim($line)));
            }

        } else if($options[0] == 'push') {

            echo EL;
            echo "Enter Model option (create/push)2:".EL.">> ";
            $line = fgets(STDIN, 32);
        }

    }



    public function create($name) {
        $path = MODELS_PATH . DS . $name . '.php';

        $resp = file_put_contents($path, $this->modelFrame($name));

        $message = $resp ? 'Creating Model ' : 'An error occur while creating Model: ' . $name;
        Util::cmdPrint($message, 1);
    }

    private function modelFrame($name){
        return (
            '<?php
namespace Zikzay\Model;

use stdClass as std;
use Zikzay\Core\Model;

class '.$name.' extends Model {



    public function __construct()
    {
        parent::__construct();
    }

    public static function define(std $field) : std
    {
        $field->id = self::primaryKey();
        //TODO: enter other database fields/column here
        $field->created_at = self::timestampField();
        $field->updated_at = self::timestampField(true);
        
        return $field;
    }
    
    
}');
    }
}