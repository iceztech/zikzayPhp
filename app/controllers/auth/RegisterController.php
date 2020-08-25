<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 8/8/2020
 *Time: 12:35 AM
 */

namespace Zikzay\Controller;





use Zikzay\Core\Controller;
use Zikzay\Core\View;
use Zikzay\Lib\Util;
use Zikzay\Model\Users;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
    }

    public function index() {

        new View("auth/register");
    }

    public function create()
    {
        $users = new Users();
        Users::$data = $this->getRequest($users);
        $this->register($users->createUser());
    }


    public function register($user)
    {
        $this->registered($user);
    }


    protected function guard()
    {
     //
    }

    protected function registered($user)
    {
        Users::object($user);
        $this->api(Users::object($user));
//        header("location: ../home/index");
    }

    private function api($class_object)
    {
        Util::$status = true;
        Util::$message = 'Successful';
        Util::object_result($class_object);
    }

}