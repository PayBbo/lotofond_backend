<?php

namespace App\Exceptions\CustomExceptions;

use Exception;

class BaseException extends Exception
{
    private $title;
    private $detail;

    public function __construct(String $title, int $code, String $detail)
    {
        parent::__construct($detail, $code);
        $this->title=$title;
        $this->detail=$detail;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDetail(){
        return $this->detail;
    }
}
