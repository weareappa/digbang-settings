<?php

namespace Digbang\Settings\Entities;

use Cake\Chronos\Chronos;

class TimeSetting extends Setting
{
    public const FORMAT = 'H:i';

    public function getValue(): ?string
    {
        $value = $this->internalValue();
        if (! $value) {
            return null;
        }

        return $value->format(static::FORMAT);
    }

    protected function assertValid($value): void
    {
        try {
            Chronos::createFromFormat(static::FORMAT, (string) $value);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException;
        }
    }

    private function internalValue(): ?Chronos
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return Chronos::createFromFormat('H:i', (string) $this->value);
    }
}
