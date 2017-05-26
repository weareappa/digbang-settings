<?php

namespace Digbang\Settings\Entities;

class IntSetting extends Setting
{
    protected function assertValid($value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException;
        }
    }

    public function getValue(): ?int
    {
        if($this->isNullable() && $this->value === null) {
            return null;
        }

        return (int)$this->value;
    }
}
