<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

trait ClassTrait
{
    function addClass(string $value)
    {
        if(!$attr = $this->getAttribute('class'))
        {
            $attr = $this->addAttribute('class');
        }

        $value = preg_replace('/[\s]{2,}/', ' ', $value);

        $values = (array) explode(' ', $value);
        $attr->setValues(array_diff($values, ['']));
    }

    function removeClass(string $value)
    {
        if(!$attr = $this->getAttribute('class'))
        {
            return false;
        }

        return $attr->removeValue($value);
    }

    function hasClass(string $value)
    {
        if(!$attr = $this->getAttribute('class'))
        {
            return false;
        }

        return $attr->hasValue($value);
    }
}