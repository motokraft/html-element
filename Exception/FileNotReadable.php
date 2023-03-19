<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class FileNotReadable extends \Exception
{
    private string $filepath;

    function __construct(string $filepath, int $code = 404)
    {
        $this->filepath = $filepath;

        $message = sprintf('File %s is not readable!', $filepath);
        parent::__construct($message, $code);
    }

    function getFilepath() : string
    {
        return $this->filepath;
    }
}