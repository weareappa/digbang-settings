<?php

declare(strict_types = 1);

namespace Digbang\Settings\Entities;

use Cake\Chronos\Chronos;
use Illuminate\Support\Arr;

class DateSettingTest extends SettingTestCase
{
    /**
     * {@inheritdoc}
     */
    public function onlyInvalidValues(array $examples): array
    {
        return Arr::except($examples, ['date', 'datetime']);
    }

    /**
     * Should return a valid initial value.
     *
     * @return mixed
     */
    protected function aValue()
    {
        return Chronos::create(
            2017,
            5,
            26,
            0,
            0,
            0,
            null
        );
    }

    /**
     * Should return another valid value to test against.
     *
     * @return mixed
     */
    protected function anotherValue()
    {
        return Chronos::create(
            2017,
            5,
            27,
            0,
            0,
            0,
            null
        );
    }

    /**
     * Creates the specific setting based on parent's constructor.
     *
     * @param mixed $value
     */
    protected function createSetting(
        string $key, string $name, string $description, $value, bool $nullable
    ): Setting {
        return new DateSetting(
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
     */
    protected function createMinimalSetting(
        string $key, string $name, string $description, $value
    ): Setting {
        return new DateSetting(
            $key,
            $name,
            $description,
            $value
        );
    }
}
