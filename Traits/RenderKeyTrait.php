<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

trait RenderKeyTrait
{
    private $render_keys = [];

    function addRenderKey(string $name, $value) : self
    {
        $this->render_keys[$name] = $value;
        return $this;
    }

    function getRenderKey(string $name, $default = null)
    {
        if(!$this->hasRenderKey($name))
        {
            return $default;
        }

        return $this->render_keys[$name];
    }

    function removeRenderKey(string $name) : bool
    {
        if(!$this->hasRenderKey($name))
        {
            return false;
        }

        unset($this->render_keys[$name]);
        return true;
    }

    function hasRenderKey(string $name) : bool
    {
        return isset($this->render_keys[$name]);
    }
}