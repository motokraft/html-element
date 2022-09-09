<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class FileNotFound extends \Exception
{
    private $filepath;

    function __construct(string $filepath, int $code = 404)
    {
        $this->filepath = $filepath;

        $text = 'File %s not found!';
        $message = sprintf($text, $filepath);

        parent::__construct($message, $code);
    }

    function getFilepath() : string
    {
        return $this->filepath;
    }
}