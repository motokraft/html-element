<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\Uri\Uri;

class HtmlAnchorElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('a', $attrs);
    }

    function setHref(Uri|string $value) : void
    {
        if($value instanceof Uri)
        {
            $value = strval($value);
        }

        $this->addAttribute('href', $value);
    }

    function setDownload(string $value) : void
    {
        $this->addAttribute('download', $value);
    }

    function getUri() : bool|Uri
    {
        if(!$this->hasAttribute('href'))
        {
            return false;
        }

        $attr = $this->getAttribute('href');
        return new Uri($attr->getValue());
    }

    function getScheme() : bool|string
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

	function getUser() : bool|string
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

	function getPass() : bool|string
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

	function getHost() : bool|string
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

	function getPort() : bool|int
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

	function getPath() : bool|string
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

    function getQuery() : bool|BaseObject
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}

	function getFragment() : bool|string
	{
		if(!$result = $this->getUri())
        {
            return false;
        }

        return $result->getScheme();
	}
}