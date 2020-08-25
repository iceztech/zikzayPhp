<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 8/1/2020
 *Time: 6:53 AM
 */

namespace Zikzay\http;


use Zikzay\core\Session;
use Zikzay\core\Validation;
use Zikzay\Lib\Util;

class Request
{
    protected static $model;
    protected static $rules;

    public static function post($requestType, $model) : array
    {
        $params = [];
        $errors = new \stdClass();
        $errorIds = new \stdClass();
        $count = 0;
        if(isset($requestType)){
            foreach ($requestType as $key => $value) {
                $validatedValue = Validation::make($key, $value, $model);
                if(is_array($validatedValue)){
                    $errors->$count = $validatedValue;
                    $errorIds->$key = $validatedValue['message'];
                    $count++;
                }else if($validatedValue != null) {
                     $model->$key = $validatedValue;
                    $params[$key] = $validatedValue;
                }
            }
        }
        $count = 0;
        if (isset($errors->$count)){
            Session::set('formError', json_decode(json_encode($errors)));;
            Session::set('formIdsError', $errorIds);
            Util::$data = Session::get('formError');
            Util::$message = 'Failed';
            Util::process_result();

            ?><script>
                window.location.href = document.referrer
            </script><?php

            exit();
        };
        return  $params;
    }

    public static function request($model) : array
    {
        $requestType = (new self)->httpMethod();
        return self::post($requestType, $model);
    }

    private function httpMethod() : array
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST') ? $_POST : $_GET;
    }
}