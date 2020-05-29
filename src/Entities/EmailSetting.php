<?php

namespace Digbang\Settings\Entities;

class EmailSetting extends Setting
{
    public function getValue(): ?string
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return (string) $this->value;
    }

    protected function assertValid($value): void
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException;
        }
    }
}
