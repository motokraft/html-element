<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class FileContentEmpty extends \Exception
{
    private string $filepath;

    function __construct(string $filepath, int $code = 404)
    {
        $this->filepath = $filepath;

        $message = sprintf('File %s is empty!', $filepath);
        parent::__construct($message, $code);
    }

    function getFilepath() : string
    {
        return $this->filepath;
    }
}