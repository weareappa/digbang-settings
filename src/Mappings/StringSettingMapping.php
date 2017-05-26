<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\StringSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class StringSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return StringSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
