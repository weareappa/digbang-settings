<?php

namespace Digbang\Settings\Entities;

class BooleanSetting extends Setting
{
    public function __toString()
    {
        return (bool) $this->value ? '✔' : '❌';
    }

    public function getValue(): ?bool
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return (bool) $this->value;
    }

    protected function assertValid($value): void
    {
        if (! is_bool($value)) {
            throw new \InvalidArgumentException;
        }
    }
}
