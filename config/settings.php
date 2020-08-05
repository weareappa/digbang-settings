<?php

return [
    'cache' => [
        'enabled' => env('SETTINGS_CACHE_ENABLED', true),
    ],
    'settings' => [
        /*
         * This is an example setting. These settings will be used by the settings:sync command
         * to maintain the database settings in sync with the project.
         *
         * Keys should be unique string constants defined either here or in a custom class.
         */
        'example_key' => [
            /*
             * The type of setting this represents.
             * Check all available settings in the Digbang\Settings\Entities namespace or
             * write your own!
             */
            'type' => Digbang\Settings\Entities\StringSetting::class,

            /*
             * A name for the setting.
             */
            'name' => 'Example',

            /*
             * A description for the setting, so that admins can understand it better.
             */
            'description' => 'An example setting',

            /*
             * A default value to be used when creating the setting.
             */
            'default' => 'Default value, change me!',

            /*
             * Whether this setting is nullable or not.
             * Not-null settings require a default value.
             */
            'nullable' => false,
        ],
    ],
];
