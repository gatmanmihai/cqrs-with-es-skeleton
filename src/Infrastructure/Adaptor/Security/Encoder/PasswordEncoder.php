<?php

namespace App\Infrastructure\Adaptor\Security\Encoder;

use App\Domain\Contract\Security\Encoder\EncoderInterface;
use App\Domain\ReadModel\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class PasswordEncoder implements EncoderInterface
{
    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function encodePassword(string $plainPassword, $salt = null): string
    {
        $encoder = $this->encoderFactory->getEncoder(User::class);

        return $encoder->encodePassword($plainPassword, $salt);
    }
}