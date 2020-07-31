<?php

if (! function_exists('setting')) {

    /**
     * @param string $key
     * @return \Digbang\Settings\Repositories\SettingsRepository
     */
    function setting(string $key)
    {
        /** @var \Digbang\Settings\Repositories\SettingsRepository $repository */
        $repository = app(\Digbang\Settings\Repositories\SettingsRepository::class);

        return $repository->getValue($key);
    }
}
