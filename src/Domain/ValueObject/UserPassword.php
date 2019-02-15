<?php

namespace App\Domain\ValueObject;

use App\Domain\Contract\Security\Encoder\EncoderInterface;
use Immutable\ValueObject\ValueObject;

final class UserPassword extends ValueObject
{
    /**
     * @var string
     */
    protected $password;

    public function __construct(string $password)
    {
        $this->with([
            'password' => $password,
        ]);

        parent::__construct();
    }

    /**
     * @param string $password
     *
     * @return UserPassword
     */
    public static function create(string $password)
    {
        return new self($password);
    }

    /**
     * @param string           $plainText
     * @param EncoderInterface $encoder
     *
     * @return UserPassword
     */
    public static function fromPlainText(string $plainText, EncoderInterface $encoder)
    {
        // make some validation here

        $hashed = $encoder->encodePassword($plainText);

        return new self($hashed);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
    }
}
