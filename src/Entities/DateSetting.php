<?php

namespace Digbang\Settings\Entities;

class DateSetting extends Setting
{
    public function __toString()
    {
        return $this->value === null ? '-' : $this->getValue()->format('d/m/Y');
    }

    public function getValue(): ?\DateTimeInterface
    {
        if ($this->isNullable() && $this->value === null) {
            return null;
        }

        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->value)->setTime(0,0,0);
    }

    protected function assertValid($value): void
    {
        if (! $value instanceof \DateTimeInterface) {
            throw new \InvalidArgumentException;
        }
    }
}
