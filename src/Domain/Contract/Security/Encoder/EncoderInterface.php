<?php

namespace App\Domain\Contract\Security\Encoder;

interface EncoderInterface
{
    /**
     * @param string $plainPassword
     * @param null   $salt
     *
     * @return string
     */
    public function encodePassword(string $plainPassword, $salt = null): string;
}