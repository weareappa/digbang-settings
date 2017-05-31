<?php

namespace Digbang\Settings;

use Digbang\Settings\Repositories\DoctrineSettingsRepository;
use Digbang\Settings\Repositories\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use LaravelDoctrine\Fluent\FluentDriver;
use LaravelDoctrine\ORM\Configuration\MetaData\MetaDataManager;
use LaravelDoctrine\ORM\Extensions\MappingDriverChain;

class SettingsServiceProvider extends ServiceProvider
{
    private const PACKAGE = 'settings';

    public function boot(EntityManagerInterface $entityManager, MetaDataManager $metadata, BladeCompiler $blade)
    {
        $this->doctrineMappings($entityManager, $metadata);
        $this->resources();

        $blade->directive('setting', function ($key) {
            $class = SettingsRepository::class;

            return "<?php echo app('$class')->getValue($key); ?>";
        });
    }

    public function register()
    {
        $this->app->bind(SettingsRepository::class, DoctrineSettingsRepository::class);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param MetaDataManager $metadata
     * @return void
     */
    protected function doctrineMappings(EntityManagerInterface $entityManager, MetaDataManager $metadata): void
    {
        /** @var FluentDriver $fluentDriver */
        $fluentDriver = $metadata->driver('fluent', ['mappings' => [
            Mappings\SettingMapping::class,
            Mappings\StringSettingMapping::class,
            Mappings\BooleanSettingMapping::class,
            Mappings\IntSettingMapping::class,
            Mappings\FloatSettingMapping::class,
            Mappings\ArraySettingMapping::class,
            Mappings\DateSettingMapping::class,
            Mappings\DateTimeSettingMapping::class,
        ]]);

        /** @var MappingDriverChain $chain */
        $chain = $entityManager->getConfiguration()->getMetadataDriverImpl();
        $chain->addDriver($fluentDriver, 'Digbang\Settings');
    }

    /**
     * @return void
     */
    protected function resources(): void
    {
        $path = dirname(__DIR__).'/resources';

        $this->loadTranslationsFrom("$path/lang", static::PACKAGE);
        $this->loadViewsFrom("$path/views", static::PACKAGE);

        $this->publishes([
            "$path/lang"  => resource_path('lang/vendor/'.static::PACKAGE),
            "$path/views" => resource_path('views/vendor/'.static::PACKAGE),
        ]);
    }
}
