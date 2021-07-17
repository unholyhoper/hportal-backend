<?php
namespace App\Services;

class SecurityService
{
    public function encodeEmail($email): string
    {
        return $email . '123';
    }
    
}