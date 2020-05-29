<?php

namespace Digbang\Settings\Entities;

use Digbang\Utils\Enumerables\Enum;

class EnumSetting extends Setting
{
    public function __toString()
    {
        if ($this->isNullable() && $this->value === null) {
            return '-';
        }

        /** @var Enum $value */
        $value = $this->getValue();

        return $value->translate();
    }

    protected function assertValid($value): void
    {
        if ($value instanceof Enum) {
            throw new \InvalidArgumentException('Only instances of Digbang\Utils\Enumerables\Enum are allowed');
        }
    }

    /**
     * @param Enum $value
     */
    protected function encode($value)
    {
        $parts = [
            'class' => get_class($value),
            'value' => $value->getValue(),
        ];

        return json_encode($parts);
    }

    protected function decode($value)
    {
        $parts = json_decode($value, true);

        /** @var Enum $classname */
        $classname = $parts['class'];
        $value = $parts['value'];

        return $classname::fromString($value);
    }
}
