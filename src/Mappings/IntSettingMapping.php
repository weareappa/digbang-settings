<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\IntSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class IntSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return IntSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
