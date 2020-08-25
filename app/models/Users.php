<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/23/2020
 *Time: 8:10 PM
 */

namespace Zikzay\Model;

use stdClass as std;
use Zikzay\Core\DatabaseFields;
use Zikzay\Core\Model;

class Users extends Model
{
    public $firstname;
    public $lastname;
    public $phone;
    public $email;
    public $state;
    public $lga;

    public $password;

    public function __construct()
    {
        parent::__construct();
    }

    public static function define(std $field) : std
    {
        $field->id = self::primaryKey();
        $field->firstname = self::nameField();
        $field->lastname = self::nameField();
        $field->phone = self::phoneField();
        $field->email = self::emailField();
        $field->password = self::passwordField();
        $field->state = self::nameField();
        $field->lga = self::nameField();
        $field->created_at = self::timestampField();
        $field->updated_at = self::timestampField(true);

        return $field;
    }


}