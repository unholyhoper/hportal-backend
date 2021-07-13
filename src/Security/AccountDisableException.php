<?php


namespace App\Security;


class AccountDisableException extends \Exception
{
    public function __construct(string $message)
    {

    }
}