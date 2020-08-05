<?php

namespace Digbang\Settings\Repositories;

use DateInterval;
use Digbang\Settings\Entities\Setting;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class CacheSettingsRepository implements SettingsRepository
{
    /** @var Repository */
    private $cache;
    /** @var DoctrineSettingsRepository */
    private $settingsRepository;

    public function __construct(Repository $cache, DoctrineSettingsRepository $settingsRepository)
    {
        $this->cache = $cache;
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * {@inheritdoc}
     *
    * @throws EntityNotFoundException
     */
    public function get(string $key): Setting
    {
        return $this->settingsRepository->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function all(): Collection
    {
        return $this->settingsRepository->all();
    }

    /**
     * {@inheritdoc}
     */
    public function search(array $filters, array $orderBy, ?int $perPage = null, int $page = 1)
    {
        return $this->settingsRepository->search($filters, $orderBy, $perPage, $page);
    }

    /**
     * {@inheritdoc}
     *
     * @throws EntityNotFoundException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getValue(string $key)
    {
        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $setting = $this->settingsRepository->get($key);

        $this->put($key, $setting->getValue());

        return $setting->getValue();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     * @throws EntityNotFoundException
     */
    public function setValue(string $key, $value): Setting
    {
        $this->settingsRepository->setValue($key, $value);

        $this->put($key, $value);
    }

    private function put(string $key, $value): void
    {
        $this->cache->put($key, $value, new DateInterval('P1Y'));
    }
}
