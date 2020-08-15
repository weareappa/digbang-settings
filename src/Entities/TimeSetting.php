<?php

namespace Digbang\Settings\Entities;

class TimeSetting extends Setting
{
    public const FORMAT = 'H:i';

    public function getValue(): ?string
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return $this->value;
    }

    protected function assertValid($value): void
    {
        if (\DateTime::createFromFormat(self::FORMAT, (string) $value) === false) {
            throw new \InvalidArgumentException;
        }
    }
}
