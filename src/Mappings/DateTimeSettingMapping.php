<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\DateTimeSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class DateTimeSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return DateTimeSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
