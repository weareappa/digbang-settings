<?php
declare(strict_types=1);

namespace Digbang\Settings\Commands;

use Digbang\Settings\Entities\Setting;
use Digbang\Settings\Repositories\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SyncCommand extends Command
{
    protected $signature = 'settings:sync {--dry-run : Only show what would be done, without doing it. }';

    protected $description = 'Sync configured settings with the database.';

    public function handle(Repository $config, SettingsRepository $settingsRepository, EntityManagerInterface $entityManager)
    {
        $exitStatus = 0;

        $existing = $settingsRepository->all();
        $configured = new Collection($config->get('settings.settings'));

        /** @var Collection $missing */
        $missing = $configured->diffKeys($existing);

        /** @var Collection|Setting[] $removed */
        $removed = $existing->diffKeys($configured);

        foreach ($missing as $key => $setting) {
            try {
                $this->validConfig($setting);

                /** @var Setting $current */
                $current = new $setting['type'](
                    $key,
                    $setting['name'],
                    Arr::get($setting, 'description', ''),
                    Arr::get($setting, 'default'),
                    Arr::get($setting, 'nullable', false)
                );

                $this->info("Added [$key].");
                $this->info(print_r($current, true), 'vvv');

                if (!$this->option('dry-run')) {
                    $entityManager->persist($current);
                }
            } catch (\InvalidArgumentException $exception) {
                $this->error("Invalid configuration for setting [$key].");
                $this->error($exception->getMessage(), 'v');

                $exitStatus++;
            }
        }

        foreach ($removed as $key => $setting) {
            $this->warn("Removed [$key].");
            $this->warn(print_r($setting, true), 'vvv');

            if (!$this->option('dry-run')) {
                $entityManager->remove($setting);
            }
        }

        if (!$this->option('dry-run')) {
            $entityManager->flush();
        }

        return $exitStatus;
    }

    private function validConfig($setting)
    {
        $errors = [];

        if (!array_key_exists('type', $setting)) {
            $errors[] = ' - Missing key: [type].';
        } elseif (!class_exists($setting['type'])) {
            $errors[] = s - printf('Class [%s] does not exist.', $setting['type']);
        } elseif (!is_subclass_of($setting['type'], Setting::class)) {
            $errors[] = s - printf('Class [%s] must extend [%s].', $setting['type'], Setting::class);
        }

        if (!array_key_exists('name', $setting)) {
            $errors[] = ' - Missing key: [name].';
        }

        if (!array_key_exists('default', $setting) && !Arr::get($setting, 'nullable')) {
            $errors[] = ' - Cannot create a not-null setting without default value.';
        }

        if (!empty($errors)) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
        }
    }
}
