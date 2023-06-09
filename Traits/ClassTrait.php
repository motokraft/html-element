<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

trait ClassTrait
{
    function addClass(string $value) : void
    {
        if(!$attr = $this->getAttribute('class'))
        {
            $attr = $this->addAttribute('class');
        }

        $values = (array) explode(' ', $value);
        $values = array_diff($values, ['']);

        foreach($values as $value)
        {
            $value = trim($value, '\\/ ');
            $attr->setValue($value);
        }
    }

    function removeClass(string $value) : bool
    {
        if(!$attr = $this->getAttribute('class'))
        {
            return false;
        }

        return $attr->removeValue($value);
    }

    function hasClass(string $value) : bool
    {
        if(!$attr = $this->getAttribute('class'))
        {
            return false;
        }

        return $attr->hasValue($value);
    }

    function replaceClass(string $old, string $new) : void
    {
        $this->removeClass($old);
        $this->addClass($new);
    }

    function conditionClass(bool $condition, mixed $value) : void
    {
        if($condition) $this->addClass($value);
    }
}