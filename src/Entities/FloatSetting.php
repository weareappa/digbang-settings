<?php

namespace Digbang\Settings\Entities;

class FloatSetting extends Setting
{
    protected function assertValid($value): void
    {
        if (!is_float($value)) {
            throw new \InvalidArgumentException;
        }
    }

    public function getValue(): ?float
    {
        if($this->isNullable() && $this->value === null) {
            return null;
        }

        return (float)$this->value;
    }
}
