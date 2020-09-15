<?php

if (! function_exists('setting')) {
    /**
     * @return mixed
     */
    function setting(string $key)
    {
        /** @var \Digbang\Settings\Repositories\SettingsRepository $repository */
        $repository = app(\Digbang\Settings\Repositories\SettingsRepository::class);

        return $repository->getValue($key);
    }
}
