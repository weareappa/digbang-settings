<?php

namespace Digbang\Settings\Entities;

class DateTimeSetting extends Setting
{
    public function __toString()
    {
        return $this->value === null ? '-' : $this->getValue()->format('d/m/Y H:i:s');
    }

    public function getValue(): ?\DateTimeInterface
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->value);
    }

    protected function assertValid($value): void
    {
        if (! $value instanceof \DateTimeInterface) {
            throw new \InvalidArgumentException;
        }
    }
}
