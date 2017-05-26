<?php
declare(strict_types=1);

namespace Digbang\Settings\Entities;

use Illuminate\Support\Arr;

class ArraySettingTest extends SettingTestCase
{
    protected function aValue()
    {
        return ['an', 'array', 'of', 'values'];
    }

    protected function anotherValue()
    {
        return ['another', 'set', 'of', 'values'];
    }

    protected function createSetting(string $key, string $name, string $description, $value, bool $nullable = false): Setting
    {
        return new ArraySetting($key, $name, $description, $value, $nullable);
    }

    protected function createMinimalSetting(string $key, string $name, string $description, $value): Setting
    {
        return new ArraySetting($key, $name, $description, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function onlyInvalidValues(array $examples): array
    {
        return Arr::except($examples, 'array');
    }
}
