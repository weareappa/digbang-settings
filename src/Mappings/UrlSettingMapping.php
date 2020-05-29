<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\UrlSetting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class UrlSettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return UrlSetting::class;
    }

    public function map(Fluent $builder)
    {
    }
}
