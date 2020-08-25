<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/25/2020
 *Time: 4:52 AM
 */


/**
 * Class HtmlElement
 */
abstract class HtmlElement
{
    abstract public function render(): string;
}