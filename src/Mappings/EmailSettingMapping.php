<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\EmailSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class EmailSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return EmailSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
