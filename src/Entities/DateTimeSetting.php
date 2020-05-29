<?php

namespace Digbang\Settings\Entities;

use Cake\Chronos\Chronos;

class DateTimeSetting extends Setting
{
    public function __toString()
    {
        return $this->value === null ? '-' : $this->getValue()->format('d/m/Y H:i:s');
    }

    public function getValue(): ?Chronos
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return Chronos::parse($this->value);
    }

    protected function assertValid($value): void
    {
        if (! $value instanceof Chronos) {
            throw new \InvalidArgumentException;
        }
    }
}
