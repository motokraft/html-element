<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

/**
 *
 * Implements an API for custom display template options
 *
 */

trait RenderKeyTrait
{
    /**
     * Array of custom output template options
     *
     * @var array<string, mixed>
     */
    private array $render_keys = [];

    /**
     * Adds a custom parameter to the output template
     *
     * @param string $name User parameter name
     * @param string $value Custom parameter value
     *
     * @return void
     */
    function addRenderKey(string $name, $value) : void
    {
        $this->render_keys[$name] = $value;
    }

    /**
     * Returns the value of the user parameter
     *
     * @param string $name User parameter name
     *
     * @return mixed Custom parameter value
     * @return bool false User parameter not found
     */
    function getRenderKey(string $name)
    {
        if(!$this->hasRenderKey($name))
        {
            return false;
        }

        return $this->render_keys[$name];
    }

    /**
     * Removes a user option
     *
     * @param string $name User parameter name
     *
     * @return bool true Custom setting deleted successfully
     * @return bool false User parameter not found
     */
    function removeRenderKey(string $name) : bool
    {
        if(!$this->hasRenderKey($name))
        {
            return false;
        }

        unset($this->render_keys[$name]);
        return true;
    }

    /**
     * Checks for the existence of a custom parameter
     *
     * @param string $name User parameter name
     *
     * @return bool true Custom setting exists
     * @return bool false User parameter not found
     */
    function hasRenderKey(string $name) : bool
    {
        return isset($this->render_keys[$name]);
    }
}