<?php

namespace Digbang\Settings\Repositories;

use Digbang\Settings\Entities\Setting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Support\Collection;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DoctrineSettingsRepository extends EntityRepository implements SettingsRepository
{
    use PaginatesFromParams;

    /**
     * The entity alias used on search queries.
     * @var string
     */
    protected const ALIAS = 's';

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Setting::class));
    }

    /**
     * {@inheritdoc}
     *
     * @throws EntityNotFoundException
     */
    public function get(string $key): Setting
    {
        /** @var Setting $setting */
        $setting = $this->find($key);

        if ($setting === null) {
            throw new EntityNotFoundException("Setting [$key] not found.");
        }

        return $setting;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): Collection
    {
        return new Collection($this->findAll());
    }

    /**
     * {@inheritdoc}
     */
    public function search(array $filters, array $orderBy, ?int $perPage = null, int $page = 1)
    {
        $queryBuilder = $this->createQueryBuilder(static::ALIAS);

        $this->parseFilters($filters, $queryBuilder);

        foreach ($orderBy as $column => $sense) {
            $queryBuilder->orderBy($column, $sense ?: 'asc');
        }

        $query = $queryBuilder->getQuery();

        if ($perPage !== null) {
            return $this->paginate($query, $perPage, $page);
        }

        return $query->getResult();
    }

    /**
     * {@inheritdoc}
     *
     * @throws EntityNotFoundException
     */
    public function getValue(string $key)
    {
        return $this->get($key)->getValue();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     * @throws EntityNotFoundException
     */
    public function setValue(string $key, $value): Setting
    {
        return $this->getEntityManager()->transactional(function () use ($key, $value) {
            $setting = $this->get($key);
            $setting->setValue($value);

            return $setting;
        });
    }

    /**
     * Parse search filters and add them to the current query.
     *
     * @param array $filters
     * @param QueryBuilder $queryBuilder
     * @return void
     */
    protected function parseFilters(array $filters, QueryBuilder $queryBuilder): void
    {
        $alias = static::ALIAS;

        if ($key = array_get($filters, 'key')) {
            $queryBuilder->andWhere("LOWER($alias.key) LIKE LOWER(:key)");
            $queryBuilder->setParameter('key', "%$key%");
        }

        if ($name = array_get($filters, 'name')) {
            $queryBuilder->andWhere("LOWER($alias.name) LIKE LOWER(:name)");
            $queryBuilder->setParameter('name', "%$name%");
        }
    }
}
