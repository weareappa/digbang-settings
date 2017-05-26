<?php

namespace Digbang\Settings\Entities;

use Carbon\Carbon;

class DateTimeSetting extends Setting
{
    protected function assertValid($value): void
    {
        if (!$value instanceof Carbon) {
            throw new \InvalidArgumentException;
        }
    }

    public function getValue(): ?Carbon
    {
        if($this->isNullable() && $this->value === null) {
            return null;
        }

        return Carbon::parse($this->value);
    }

    public function __toString()
    {
        return  $this->value === null ? '-' : $this->getValue()->format('d/m/Y H:i:s');
    }
}
