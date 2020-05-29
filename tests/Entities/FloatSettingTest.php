<?php

declare(strict_types = 1);

namespace Digbang\Settings\Entities;

use Illuminate\Support\Arr;

class FloatSettingTest extends SettingTestCase
{
    /**
     * Filters valid values out of the examples.
     *
     * @see SettingTestCase::invalidValues()
     */
    public function onlyInvalidValues(array $examples): array
    {
        return Arr::except($examples, 'float');
    }

    /**
     * Should return a valid initial value.
     *
     * @return mixed
     */
    protected function aValue()
    {
        return M_E;
    }

    /**
     * Should return another valid value to test against.
     *
     * @return mixed
     */
    protected function anotherValue()
    {
        return M_SQRT2;
    }

    /**
     * Creates the specific setting based on parent's constructor.
     *
     * @param mixed $value
     */
    protected function createSetting(
        string $key, string $name, string $description, $value, bool $nullable
    ): Setting {
        return new FloatSetting(...func_get_args());
    }

    /**
     * Creates the specific setting based on parent's constructor,
     * without specifying nullability.
     *
     * @param mixed $value
     */
    protected function createMinimalSetting(
        string $key, string $name, string $description, $value
    ): Setting {
        return new FloatSetting(...func_get_args());
    }
}
