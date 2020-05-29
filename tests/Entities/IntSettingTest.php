<?php

declare(strict_types = 1);

namespace Digbang\Settings\Entities;

use Illuminate\Support\Arr;

class IntSettingTest extends SettingTestCase
{
    /**
     * Filters valid values out of the examples.
     *
     * @return array
     *
     * @see SettingTestCase::invalidValues()
     */
    public function onlyInvalidValues(array $examples): array
    {
        return Arr::except($examples, 'int');
    }

    /**
     * Should return a valid initial value.
     *
     * @return mixed
     */
    protected function aValue()
    {
        return 123456;
    }

    /**
     * Should return another valid value to test against.
     *
     * @return mixed
     */
    protected function anotherValue()
    {
        return PHP_INT_MAX;
    }

    /**
     * Creates the specific setting based on parent's constructor.
     *
     * @param mixed $value
     *
     * @return Setting
     */
    protected function createSetting(
        string $key, string $name, string $description, $value, bool $nullable
    ): Setting {
        return new IntSetting(...func_get_args());
    }

    /**
     * Creates the specific setting based on parent's constructor,
     * without specifying nullability.
     *
     * @param mixed $value
     *
     * @return Setting
     */
    protected function createMinimalSetting(
        string $key, string $name, string $description, $value
    ): Setting {
        return new IntSetting(...func_get_args());
    }
}
