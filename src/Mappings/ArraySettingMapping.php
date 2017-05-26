<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\ArraySetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class ArraySettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return ArraySetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
