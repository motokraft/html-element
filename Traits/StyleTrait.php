<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Styles\AbstractStyle;
use \Motokraft\HtmlElement\Exception\Style\StyleClassNotFound;
use \Motokraft\HtmlElement\Exception\Style\StyleExtends;
use \Motokraft\HtmlElement\HtmlHelper;
use \Motokraft\Object\Collection;

trait StyleTrait
{
    /**
     * Contains Collection of styles
     *
     * @var Collection<string, AbstractStyle>
     */
    private Collection $styles;

    function addStyle(string $name, mixed $value = null) : AbstractStyle
    {
        if(!$style = HtmlHelper::getStyle($name))
        {
            $style = HtmlHelper::getStyle('_default');
        }

        if(!class_exists($style))
        {
            throw new StyleClassNotFound($style);
        }

        $result = new $style($name);

        if(!$result instanceof AbstractStyle)
        {
            throw new StyleExtends($result);
        }

        if($value) $result->setValue($value);
        $this->styles->set($name, $result);

        return $result;
    }

    function getStyle(string $name) : bool|AbstractStyle
    {
        if(!$this->hasStyle($name))
        {
            return false;
        }

        return $this->styles->get($name);
    }

    function removeStyle(string $name) : bool
    {
        if(!$this->hasStyle($name))
        {
            return false;
        }

        $this->styles->remove($name);
        return true;
    }

    function hasStyle(string $name) : bool
    {
        return $this->styles->hasKey($name);
    }

    function getStyles() : Collection
    {
        return $this->styles;
    }
}