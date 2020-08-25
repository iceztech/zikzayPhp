<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/25/2020
 *Time: 4:51 AM
 */

/**
 * Class Form
 */
class Form extends HtmlElement
{
    public $action;
    public $method;
    public $formData;

    /**
     * @var \BaseInput[]
     */
    private $elements = [];

    /**
     * Form constructor.
     *
     * @param string $action
     * @param string $method
     */
    public function __construct(string $action = '', string $method = 'get', string $formData = '')
    {
        $this->action = $action;
        $this->method = $method;
    }

    public function addElement(HtmlElement $el)
    {
        $this->elements[] = $el;
    }

    public function render(): string
    {
        $inputs = implode(PHP_EOL, array_map(fn($el) => $el->render(), $this->elements));

        return sprintf('<form action="%s" method="%s">
            %s
        </form>', $this->action, $this->method, $inputs);
    }
}