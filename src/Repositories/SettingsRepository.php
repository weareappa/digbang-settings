<?php

namespace Digbang\Settings\Repositories;

use Digbang\Settings\Entities\Setting;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SettingsRepository
{
    /**
     * Get a setting by key.
     *
     * @return Setting
     */
    public function get(string $key): Setting;

    /**
     * Gets the settings value directly.
     *
     * @return mixed
     */
    public function getValue(string $key);

    /**
     * Get all settings.
     *
     * @return Setting[]|Collection
     */
    public function all(): Collection;

    /**
     * Set a setting's value directly.
     *
     * @param mixed $value
     *
     * @return Setting
     */
    public function setValue(string $key, $value): Setting;

    /**
     * Search for settings by key or name.
     *
     * @param int $perPage
     *
     * @return Setting[]|LengthAwarePaginator
     */
    public function search(array $filters, array $orderBy, ?int $perPage = null, int $page = 1);
}
