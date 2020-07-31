<?php

if (! function_exists('settings')) {

    /**
     * @return \Digbang\Settings\Repositories\SettingsRepository
     */
    function settings(): \Digbang\Settings\Repositories\SettingsRepository
    {
        /** @var \Digbang\Settings\Repositories\SettingsRepository $repository */
        $repository = app(\Digbang\Settings\Repositories\SettingsRepository::class);

        return $repository;
    }
}
