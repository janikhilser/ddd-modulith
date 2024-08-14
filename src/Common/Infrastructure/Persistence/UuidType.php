<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Exception;

abstract class UuidType extends Type
{
    /**
     * @codeCoverageIgnore
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value || '' === $value) {
            return null;
        }

        try {
            $fqcn = $this->getValueObjectClassName();

            return new $fqcn($value);
        } catch (Exception $e) {
            throw ConversionException::conversionFailed($value, $this->getName(), $e);
        }
    }

    abstract protected function getValueObjectClassName(): string;

    abstract public function getName(): string;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        $fqcn = $this->getValueObjectClassName();

        if (is_scalar($value)) {
            $value = new $fqcn($value);
        }

        if (!is_a($value, $fqcn)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [$fqcn]);
        }

        return (string) $value;
    }
}
