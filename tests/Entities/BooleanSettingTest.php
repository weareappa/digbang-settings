<?php

declare(strict_types = 1);

namespace Digbang\Settings\Entities;

use Illuminate\Support\Arr;

class BooleanSettingTest extends SettingTestCase
{
    /**
     * {@inheritdoc}
     */
    public function onlyInvalidValues(array $examples): array
    {
        return Arr::except($examples, 'boolean');
    }

    /**
     * Should return a valid initial value.
     *
     * @return mixed
     */
    protected function aValue()
    {
        return true;
    }

    /**
     * Should return another valid value to test against.
     *
     * @return mixed
     */
    protected function anotherValue()
    {
        return false;
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
        return new BooleanSetting(
            $key,
            $name,
            $description,
            $value,
            $nullable
        );
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
        return new BooleanSetting(
            $key,
            $name,
            $description,
            $value
        );
    }
}
