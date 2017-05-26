<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\BooleanSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class BooleanSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return BooleanSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
