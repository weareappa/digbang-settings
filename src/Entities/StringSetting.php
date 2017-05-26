<?php

namespace Digbang\Settings\Entities;

class StringSetting extends Setting
{
    protected function assertValid($value): void
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException;
        }
    }

    public function getValue(): ?string
    {
        if($this->isNullable() && $this->value === null) {
            return null;
        }

        return (string)$this->value;
    }
}
