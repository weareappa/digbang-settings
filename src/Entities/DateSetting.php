<?php

namespace Digbang\Settings\Entities;

use Cake\Chronos\Chronos;

class DateSetting extends Setting
{
    public function __toString()
    {
        return $this->value === null ? '-' : $this->getValue()->format('d/m/Y');
    }

    public function getValue(): ?Chronos
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return Chronos::parse($this->value)->startOfDay();
    }

    protected function assertValid($value): void
    {
        if (! $value instanceof Chronos) {
            throw new \InvalidArgumentException;
        }
    }
}
