<?php

namespace Digbang\Settings\Entities;

class FloatSetting extends Setting
{
    public function getValue(): ?float
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return (float) $this->value;
    }

    protected function assertValid($value): void
    {
        if (! is_float($value)) {
            throw new \InvalidArgumentException;
        }
    }
}
