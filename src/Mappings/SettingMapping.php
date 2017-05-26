<?php

namespace Digbang\Settings\Mappings;

use Digbang\Settings\Entities\Setting;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class SettingMapping extends EntityMapping
{
    public function mapFor()
    {
        return Setting::class;
    }

    public function map(Fluent $builder)
    {
        $builder->string('key')->primary();
        $builder->string('name');
        $builder->string('description');
        $builder->text('value')->nullable();
        $builder->boolean('nullable');
        $builder->singleTableInheritance()->column('type');
    }
}
