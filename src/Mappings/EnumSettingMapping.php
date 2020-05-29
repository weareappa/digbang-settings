<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\EnumSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class EnumSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return EnumSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
