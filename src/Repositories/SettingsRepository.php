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
     * @param string $key
     * @return Setting
     */
    public function get(string $key): Setting;

    /**
     * Gets the settings value directly.
     *
     * @param string $key
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
     * @param string $key
     * @param mixed $value
     * @return Setting
     */
    public function setValue(string $key, $value): Setting;

    /**
     * Search for settings by key or name.
     *
     * @param array $filters
     * @param array $orderBy
     * @param int $perPage
     * @param int $page
     * @return Setting[]|LengthAwarePaginator
     */
    public function search(array $filters, array $orderBy, ?int $perPage = null, int $page = 1);
}
