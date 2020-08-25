<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/25/2020
 *Time: 4:51 AM
 */

/**
 * Class Button
 *
 */
class Button extends HtmlElement
{
    public string $text;

    /**
     * Button constructor.
     *
     * @param string $text
     * @param array  $attributes
     */
    public function __construct(string $text, array $attributes = [])
    {
        $this->text = $text;
    }

    public function render(): string
    {
        return sprintf('<button>%s</button>', $this->text);
    }
}