<?php
namespace App\DBAL;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class SellerEnumType extends Type
{
    const SELLER_ENUM = 'sellerenum';
    const STOCK = 'O';
    const DEPOSIT = 'N';
    const VIRTUAL = 'V';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return "ENUM('O', 'N', 'V')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (!in_array($value, array(self::STOCK, self::DEPOSIT, self::VIRTUAL))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        return $value;
    }

    public function getName(): string
    {
        return self::SELLER_ENUM;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
