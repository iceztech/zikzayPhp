<?php
namespace Zikzay\Controller;


use Zikzay\Core\Controller;
use Zikzay\Core\View;
use Zikzay\Lib\Util;
use Zikzay\Model\Users;

class LoginController extends Controller
{

    public function __construct()
    {
        //TODO: Handle authentication here
        //TODO:NCreate an alias for namespace to make class call very easy

    }

    public function index ($params) 
    {
        new View("auth/login", $params);

    }
    public function create($params) 
    {
        $users = new Users();

         Users::$data = $this->getRequest($users);

        $class_object = $users::find(Users::$data['phone']);

        if($class_object) {
            $this->login($class_object);
        }else {
            Util::$message = 'Failed';
            Util::process_result();
        }


        //header("location: /");
    }

    private function login($class_object)
    {
        if($class_object->password == Users::$data['password']) {
            Util::$status = true;
            Util::$message = 'Successful';
            Util::object_result($class_object);
        } else {

            Util::$message = 'Failed';
            Util::process_result();
        }
    }

}