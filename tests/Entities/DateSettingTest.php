<?php
declare(strict_types=1);

namespace Digbang\Settings\Entities;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class DateSettingTest extends SettingTestCase
{
    /**
     * Should return a valid initial value.
     *
     * @return mixed
     */
    protected function aValue()
    {
        return Carbon::create(
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
        return Carbon::create(
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
     * @param string $key
     * @param string $name
     * @param string $description
     * @param mixed $value
     * @param bool $nullable
     *
     * @return Setting
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
     * @param string $key
     * @param string $name
     * @param string $description
     * @param mixed $value
     * @param bool $nullable
     *
     * @return Setting
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

    /**
     * {@inheritdoc}
     */
    public function onlyInvalidValues(array $examples): array
    {
        return Arr::except($examples, ['date', 'datetime']);
    }
}
