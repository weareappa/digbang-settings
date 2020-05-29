<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\TimeSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class TimeSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return TimeSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
