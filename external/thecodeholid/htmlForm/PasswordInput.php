<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/25/2020
 *Time: 4:53 AM
 */

/**
 * Class PasswordInput
 */
class PasswordInput extends BaseInput
{

    public function renderInput(): string
    {
        return sprintf('<input type="password" name="%s" value="%s"/>', $this->name, $this->value);
    }
}