<?php

namespace Digbang\Settings\Entities;

class ArraySetting extends Setting
{
    protected function assertValid($value): void
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException('Only array values are allowed.');
        }
    }

    public function __toString()
    {
        return implode(', ', $this->getValue() ?: []);
    }

    protected function encode($value)
    {
        return json_encode($value);
    }

    protected function decode($value)
    {
        return json_decode($value, true);
    }
}
