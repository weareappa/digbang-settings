<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\FloatSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class FloatSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return FloatSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
