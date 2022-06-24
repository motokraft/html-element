<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

defined('DEBUG') or define('DEBUG', true);

use \Motokraft\HtmlElement\ShortCode\ShortCodeInterface;
use \Motokraft\HtmlElement\Exception\ShortCodeClassNotFound;
use \Motokraft\HtmlElement\Exception\ShortCodeNotFound;
use \Motokraft\HtmlElement\Exception\ShortCodeImplement;
use \Motokraft\HtmlElement\Exception\ShortCodeExtends;

class HtmlElement
{
    use Traits\AttributeTrait,
        Traits\StyleTrait,
        Traits\ClassTrait,
        Traits\RenderTrait,
        Traits\RenderKeyTrait,
        Traits\SelectorTrait;

    private $type;
    private $level = 0;
    private $parent;
    private $attrs;
    private $styles;
	private $before = [];
	private $childrens = [];
	private $after = [];
    private $comment_before = [];
    private $comment_after = [];

    function __construct(string $type, array $attrs = [])
    {
        $this->attrs = new Iterator\ItemsIterator;
        $this->styles = new Iterator\ItemsIterator;

        if(empty($type))
        {
            throw new \Exception('Item type required!');
        }

        $this->setType($type);

        if(!empty($attrs))
        {
            $this->loadAttributes($attrs);
        } 
    }

    function setType(string $type) : static
    {
        $this->type = $type;
        return $this;
    }

    function getType() : string
    {
        return $this->type;
    }

    function hasType(string $type) : bool
    {
        return ($this->type === $type);
    }

    function setId(string $value) : Attributes\BaseAttribute
    {
        return $this->addAttribute('id', $value);
    }

    function getId() : bool|Attributes\BaseAttribute
    {
        if(!$this->hasAttribute('id'))
        {
            return false;
        }

        return $this->getAttribute('id');
    }

    function setParent(HtmlElement $parent) : static
    {
        $this->parent = $parent;
        return $this;
    }

    function getParent() : static
    {
        return $this->parent;
    }

    function setLevel(int $level) : static
    {
        $this->level = (int) $level;
        return $this;
    }

    function getLevel() : int
    {
        return $this->level;
    }

    function before(string $result, bool $escape = true) : static
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        array_push($this->before, $result);
        return $this;
	}

    function beforeHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel(($this->level + 1));
        $element->setParent($this);

        array_push($this->before, $element);
        return $element;
	}

    function beforeCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        $result = new HtmlElement($type, $attrs);
        return $this->beforeHtml($result);
	}

    function beforeShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->beforeHtml($element);
    }

    function beforeCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->beforeShortCode($result);
    }

	function prepend(string $result, bool $escape = true) : static
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        array_unshift($this->childrens, $result);
        return $this;
	}

    function prependHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel(($this->level + 1));
        $element->setParent($this);

        array_unshift($this->childrens, $element);
        return $element;
	}

    function prependCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        $result = new HtmlElement($type, $attrs);
        return $this->prependHtml($result);
	}

    function prependShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->prependHtml($element);
    }

    function prependCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->prependShortCode($result);
    }

	function html(string $result, bool $escape = true) : static
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        $this->childrens = [$result];
        return $this;
	}

    function append(string $result, bool $escape = true) : static
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        array_push($this->childrens, $result);
        return $this;
	}

	function appendHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel(($this->level + 1));
        $element->setParent($this);

        array_push($this->childrens, $element);
        return $element;
	}

    function appendCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        $result = new HtmlElement($type, $attrs);
        return $this->appendHtml($result);
	}

    function appendShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->appendHtml($element);
    }

    function appendCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->appendShortCode($result);
    }

	function after(string $result, bool $escape = true) : static
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        array_push($this->after, $result);
        return $this;
	}

    function afterHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel($this->level);
        $element->setParent($this);

        array_push($this->after, $element);
        return $element;
	}

    function afterCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        $result = new HtmlElement($type, $attrs);
        return $this->afterHtml($result);
	}

    function afterShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->appendHtml($element);
    }

    function afterCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->afterHtml($result);
    }

    function remove() : bool
    {
        if(!$this->parent instanceof HtmlElement)
        {
            return false;
        }

        return $this->parent->removeChild($this);
    }

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

    function hasChildElement(HtmlElement $element) : bool
    {
        return in_array($element, $this->childrens, true);
    }

    function replace(HtmlElement $newChild) : bool
    {
        if(!$this->parent instanceof HtmlElement)
        {
            return false;
        }

        return $this->parent->replaceChild($newChild, $this);
    }

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

    function setCommentBefore(string $value) : static
    {
        if($args = array_slice(func_get_args(), 1))
        {
            $value = vsprintf($value, $args);
        }

        array_push($this->comment_before, $value);
        return $this;
    }

    function setCommentAfter(string $value) : static
    {
        if($args = array_slice(func_get_args(), 1))
        {
            $value = vsprintf($value, $args);
        }

        array_push($this->comment_after, $value);
        return $this;
    }

    function render() : string
    {
        if(!$tmpl = self::getRender($this->type))
        {
            $tmpl = self::getRender('_default');
        }

        if(empty($tmpl))
        {
            throw new \Exception('Item render not found!');
        }

        $this->addRenderKey('type', $this->type);

        if(DEBUG)
        {
            $this->addAttrData('level', $this->level);
        }

        if($style = $this->styles->implode(' '))
        {
            $this->addAttribute('style', $style);
        }

        if($attr = $this->attrs->implode(' '))
        {
            $this->addRenderKey('attrs', ' ' . $attr);
        }

        preg_match_all('#\{([^body].*)\}#iU', $tmpl, $matches, 2);

        foreach($matches as $matche)
        {
            $value = $this->getRenderKey($matche[1]);
            $tmpl = str_replace($matche[0], $value, $tmpl);
        }

        $indent = PHP_EOL . str_repeat("\t", $this->level);

        if(!empty($this->childrens))
        {
            $separator = null;

            if(DEBUG && ($this->type !== 'textarea'))
            {
                $body = $indent . "\t{body}" . $indent;

                $tmpl = str_replace('{body}', $body, $tmpl);
                $separator = $indent . "\t";
            }

            $body = implode($separator, $this->childrens);
            $tmpl = str_replace('{body}', $body, $tmpl);
        }
        else
        {
            $tmpl = str_replace('{body}', null, $tmpl);
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

    function __toString() : string
	{
		return (string) $this->render();
	}

    function getChildrens() : array
    {
        return $this->childrens;
    }

    private function escape(string $result) : string
    {
        $result = preg_replace('/[\r\n\t]+/', '', $result);
        return preg_replace('/\s+/u', ' ', $result);
    }

    private function createClassShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        if(!HtmlHelper::hasShortCode($type))
        {
            throw new ShortCodeNotFound($type);
        }

        $class = HtmlHelper::getShortCode($type);

        if(!class_exists($class))
        {
            throw new ShortCodeClassNotFound($class);
        }

        $tagname = HtmlHelper::SHORTCODE_DEFAULT_TAGNAME;

        if(!empty($options['tagname']))
        {
            $tagname = $options['tagname'];
        }

        $result = new $class($tagname, $attrs);

        if(!$result instanceof ShortCodeInterface)
        {
            throw new ShortCodeImplement($result);
        }

        if(!$result instanceof HtmlElement)
        {
            throw new ShortCodeExtends($result);
        }

        if(!empty($options))
        {
            $result->loadOptions($options);
        }

        return $result;
    }
}