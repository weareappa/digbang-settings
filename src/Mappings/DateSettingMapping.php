<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\DateSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class DateSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return DateSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
