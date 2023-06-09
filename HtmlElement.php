<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Attributes\AbstractAttribute;
use \Motokraft\HtmlElement\Exception\RenderItemNotFound;
use \Motokraft\Object\Collection;

/**
 *
 * This constant determines the construction of the DOM tree
 * Don't forget to define this constant in your application
 *
 * @return bool true Consider nesting levels of html elements
 * @return bool false Single line output without line breaks
 */
defined('DEBUG') or define('DEBUG', true);

/**
 *
 * Implements an API interface for a single html element
 *
 */

class HtmlElement
{
    /**
     *
     * Implements an API to add before an html element
     *
     */
    use Traits\BeforeTrait;

    /**
     *
     * Implements an API for prepending child elements
     *
     */
    use Traits\PrependTrait;

    /**
     *
     * Implements an API for appending child elements to the end
     *
     */
    use Traits\AppendTrait;

    /**
     *
     * Implements the API for adding after the html element
     *
     */
    use Traits\AfterTrait;

    /**
     *
     * Implements an API for adding a ShortCode element
     *
     */
    use Traits\ShortCodeTrait;

    /**
     *
     * Implements an API interface for working with attributes
     *
     */
    use Traits\AttributeTrait;

    /**
     *
     * Implements an API interface for working with styles.
     *
     */
    use Traits\StyleTrait;

    /**
     *
     * Implements an API interface for working with classes
     *
     */
    use Traits\ClassTrait;

    /**
     *
     * Implements an API interface for string output
     *
     */
    use Traits\RenderTrait;

    /**
     *
     * Implements an API for custom display template options
     *
     */
    use Traits\RenderKeyTrait;

    /**
     *
     * Implements an API for traversing the DOM tree of html elements
     *
     */
    use Traits\SelectorTrait;

    /**
     * Contains the html element type
     *
     * @var string
     */
    private string $type;

    /**
     * Specifies the level of nesting
     *
     * @var int
     */
    private int $level = 0;

    /**
     * Contains a child instance of the HtmlElement class
     *
     * @var null|HtmlElement
     */
    private ?self $parent = null;

    /**
     * Contains an array of child elements
     *
     * @var array<string|HtmlElement>
     */
	private array $childrens = [];

    /**
     * Array of html comments before html element
     *
     * @var array<string>
     */
    private array $comment_before = [];

    /**
     * Array of html comments after html element
     *
     * @var array<string>
     */
    private array $comment_after = [];

    /**
     * Creates a new instance of the HtmlElement class
     *
     * @param string $type Contains the element's html tag
     * @param array $attrs Contains an array of attributes
     *
     * @exception \Exception Element html tag not specified
     *
     * @return void
     */
    function __construct(string $type, array $attrs = [])
    {
        if(empty($type))
        {
            throw new \Exception('Item type required!');
        }

        $this->styles = new Collection;

        if(!empty($attrs))
        {
            $this->loadAttributes($attrs);
        } 
    }

    /**
     * Specifies a new html element tag
     *
     * @param string $type Contains the element's html tag
     *
     * @return HtmlElement Returns the current class instance
     */
    function setType(string $type) : HtmlElement
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Returns the current html tag of the element
     *
     * @return string 
     */
    function getType() : string
    {
        return $this->type;
    }

    /**
     * Checks the current html tag of an element
     *
     * @param string $type Contains the element's html tag
     *
     * @return bool true Passed tag is the same
     * @return bool false Passed tag is different
     */
    function hasType(string $type) : bool
    {
        return ($this->type === $type);
    }

    /**
     * Sets the id attribute with its value
     *
     * @param string $value Contains the value of the id attribute
     *
     * @return AbstractAttribute Attribute class
     */
    function setId(string $value) : AbstractAttribute
    {
        return $this->addAttribute('id', $value);
    }

    /**
     * Returns the class of the id attribute
     *
     * @return AbstractAttribute Attribute class
     * @return bool false Attribute not found
     */
    function getId() : bool|AbstractAttribute
    {
        if(!$this->hasAttribute('id'))
        {
            return false;
        }

        return $this->getAttribute('id');
    }

    /**
     * Sets the parent HtmlElement class
     *
     * @param HtmlElement $parent Parent class HtmlElement
     *
     * @return HtmlElement Returns the current class instance
     */
    function setParent(HtmlElement $parent) : HtmlElement
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Returns the parent class
     *
     * @return HtmlElement Parent class
     * @return null Parent class not set
     */
    function getParent() : null|HtmlElement
    {
        return $this->parent;
    }

    /**
     * Specifies a numeric nesting level
     *
     * @param int $level Numeric nesting level
     *
     * @return HtmlElement Returns the current class instance
     */
    function setLevel(int $level) : HtmlElement
    {
        $this->level = (int) $level;
        return $this;
    }

    /**
     * Returns the numeric nesting level
     *
     * @return int Numeric nesting level
     */
    function getLevel() : int
    {
        return $this->level;
    }

    /**
     * Clears the array of children and adds one string value
     *
     * @param string $value string value
     * @param bool $escape Removes extra garbage from a string
     *
     * @return HtmlElement Returns the current class instance
     */
	function html(string $result, bool $escape = true) : HtmlElement
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        $this->childrens = [$result];
        return $this;
	}

    /**
     * Removes the passed HtmlElement class from the list of child elements
     *
     * @param HtmlElement $element The class to be removed
     *
     * @return bool true Passed class removed successfully
     * @return bool false The passed class was not found in the list of child elements
     */
    function removeChild(HtmlElement $element) : bool
    {
        if(!$this->hasChildElement($element))
        {
            return false;
        }

        $key = array_search($element, $this->childrens);

        if($key !== false)
        {
            unset($this->childrens[$key]);
            return true;
        }

        return false;
    }

    /**
     * Looks for the passed class in the list of child elements
     *
     * @param HtmlElement $element Element to find
     *
     * @return bool true Passed class found
     * @return bool false Passed class not found
     */
    function hasChildElement(HtmlElement $element) : bool
    {
        return in_array($element, $this->childrens, true);
    }

    /**
     * Replacing the current HtmlElement class with the passed one
     *
     * @param HtmlElement $newChild Element to replace
     *
     * @return bool true Replacement completed successfully
     * @return bool false The current element has no parent
     */
    function replace(HtmlElement $newChild) : bool
    {
        if(!$this->parent instanceof HtmlElement)
        {
            return false;
        }

        return $this->parent->replaceChild($newChild, $this);
    }

    /**
     * Replaces an instance of the HtmlElement class in a list of child elements
     *
     * @param HtmlElement $newChild New element to replace
     * @param HtmlElement $oldChild Current replacement element
     *
     * @return bool true Replacement completed successfully
     * @return bool false Current element not found in child elements
     * @return bool false The new element already exists in the list of children
     */
    function replaceChild(HtmlElement $newChild, HtmlElement $oldChild) : bool
    {
        if(!$this->hasChildElement($oldChild))
        {
            return false;
        }

        if($this->hasChildElement($newChild))
        {
            return false;
        }

        $key = array_search($oldChild, $this->childrens);

        if($key !== false)
        {
            $level = (int) $this->getLevel();
            $newChild->setLevel(($level + 1));

            $newChild->setParent($this);
            $this->childrens[$key] = $newChild;

            return true;
        }

        return false;
    }

    /**
     * Adds an html comment before the current element
     *
     * @param string $value Comment value
     *
     * @return HtmlElement Returns the current class instance
     */
    function setCommentBefore(string $value) : HtmlElement
    {
        if($args = array_slice(func_get_args(), 1))
        {
            $value = vsprintf($value, $args);
        }

        array_push($this->comment_before, $value);
        return $this;
    }

    /**
     * Adds an html comment after the current element
     *
     * @param string $value Comment value
     *
     * @return HtmlElement Returns the current class instance
     */
    function setCommentAfter(string $value) : HtmlElement
    {
        if($args = array_slice(func_get_args(), 1))
        {
            $value = vsprintf($value, $args);
        }

        array_push($this->comment_after, $value);
        return $this;
    }

    /**
     * Returns a string representation of the current element
     *
     * @return string The string representation of the html element
     */
    function render() : string
    {
        if(!$tmpl = self::getRender($this->type))
        {
            $tmpl = self::getRender('_default');
        }

        if(empty($tmpl))
        {
            throw new RenderItemNotFound($this);
        }

        $this->addRenderKey('type', $this->type);

        if(DEBUG)
        {
            $this->addAttrData('level', $this->level);
        }

        if($value = $this->styles->implodeValue(' '))
        {
            $this->addAttribute('style', $value);
        }

        if($attr_value = implode(' ', $this->attrs))
        {
            $this->addRenderKey('attrs', ' ' . $attr_value);
        }

        preg_match_all('#\{([^body].*)\}#iU', $tmpl, $matches, 2);

        $map_matche = function (array $data)
        {
            return strtolower($data[1]);
        };

        $data = array_map($map_matche, $matches);

        foreach(array_unique($data) as $name)
        {
            $value = $this->getRenderKey($name);

            $tmpl = str_replace(
                '{' . $name . '}', $value, $tmpl
            );
        }

        $indent = PHP_EOL . str_repeat("\t", $this->level);

        if($childrens = $this->getChildrens())
        {
            $separator = '';

            if(DEBUG && ($this->type !== 'textarea'))
            {
                $body = $indent . "\t{body}" . $indent;

                $tmpl = str_replace('{body}', $body, $tmpl);
                $separator = $indent . "\t";
            }

            $body = implode($separator, $childrens);
            $tmpl = str_replace('{body}', $body, $tmpl);
        }
        else
        {
            $tmpl = str_replace('{body}', '', $tmpl);
        }

        if(DEBUG && !empty($this->comment_before))
        {
            $values = array_map(function ($value) {
                return '<!-- ' . $value . ' -->';
            }, $this->comment_before);

            $comment = implode($indent, $values);
            $tmpl = $indent . $comment . $indent . $tmpl;
        }

        if(!empty($this->before))
		{
            $before = implode('', $this->before);
            if(DEBUG) { $before .= $indent; }

		    $tmpl = $before . $tmpl;
		}

        if(DEBUG && !empty($this->comment_after))
        {
            $values = array_map(function ($value) {
                return '<!-- ' . $value . ' -->';
            }, $this->comment_after);

            $comment = implode($indent, $values);
            $tmpl .= $indent . $comment . PHP_EOL;
        }

        if(!empty($this->after))
		{
            if(DEBUG) { $tmpl .= $indent; }
			$tmpl .= implode('', $this->after);
		}

        return (string) $tmpl;
    }

    /**
     * Returns a string representation of the current element
     *
     * @return string The string representation of the html element
     */
    function __toString() : string
	{
		return (string) $this->render();
	}

    /**
     * Returns an array of child elements
     *
     * @return array Array of child elements
     */
    function getChildrens() : array
    {
        return $this->childrens;
    }

    /**
     * Parses an HTML document from a file
     *
     * @param string $filepath Full path to the file
     * @param bool $shortcode Finding and processing shortcode elements in a string
     *
     * @return HtmlElement The HtmlElement class to add to
     *
     * @exception FileNotReadable File not found or not readable
     * @exception FileContentEmpty File is empty
     */
    function loadFile(string $filepath, bool $shortcode = true) : HtmlElementCollection
    {
        return HtmlHelper::loadFile($filepath, $this, $shortcode);
    }

    /**
     * Parses the HTML contained in a string
     *
     * @param string $source HTML string to parse
     * @param bool $shortcode Finding and processing shortcode elements in a string
     *
     * @return HtmlElement The HtmlElement class to add to
     */
    function loadHTML(string $source, bool $shortcode = true) : HtmlElementCollection
    {
        return HtmlHelper::loadHTML($source, $this, $shortcode);
    }

    /**
     * Removes extra garbage from a string
     *
     * @param string $result string value
     *
     * @return string cleared string
     */
    private function escape(string $result) : string
    {
        $result = preg_replace('/[\r\n\t]+/', '', $result);
        return preg_replace('/\s+/u', ' ', $result);
    }
}