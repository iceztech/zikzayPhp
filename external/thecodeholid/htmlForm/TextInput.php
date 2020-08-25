<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/25/2020
 *Time: 4:54 AM
 */

/**
 * Class TextInput
 */
class TextInput extends BaseInput
{

    public function renderInput(): string
    {
        return sprintf('<input type="text" name="%s" value="%s"/>', $this->name, $this->value);
    }
}