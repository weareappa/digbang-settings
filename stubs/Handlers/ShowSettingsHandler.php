<?php

namespace App\Http\Backoffice\Handlers\Settings;

use App\Http\Backoffice\Handlers\Dashboard\DashboardHandler;
use App\Http\Backoffice\Handlers\Handler;
use App\Http\Kernel;
use App\Http\Utils\RouteDefiner;
use Digbang\Security\Exceptions\SecurityException;
use Digbang\Settings\Repositories\SettingsRepository;
use Illuminate\Routing\Router;

class ShowSettingsHandler extends Handler implements RouteDefiner
{
    protected $titlePlural = 'Configuraciones';

    public function __invoke(string $key, SettingsRepository $repository)
    {
        $setting = $repository->get($key);

        $breadcrumb = backoffice()->breadcrumb([
            trans('backoffice::default.home') => DashboardHandler::route(),
            $this->titlePlural => ListSettingsHandler::route(),
            $setting->getName(),
        ]);

        $data = [
            trans('settings::common.key') => $setting->getKey(),
            trans('settings::common.name') => $setting->getName(),
            trans('settings::common.description') => $setting->getDescription(),
            trans('settings::common.value') => (string) $setting,
        ];

        $actions = backoffice()->actions();
        try {
            $actions->link(
                security()->url()->to(ListSettingsHandler::route()),
                fa('arrow-left') . ' ' . trans('backoffice::default.back'),
                ['class' => 'btn btn-default']
            );
        } catch (SecurityException $e) {
        }

        $topActions = backoffice()->actions();
        try {
            $topActions->link(
                security()->url()->to(ListSettingsHandler::route()),
                fa('arrow-left') . ' ' . trans('backoffice::default.back')
            );
        } catch (SecurityException $ex) {
            /* Do nothing */
        }

        return view()->make('backoffice::show', [
            'title' => $this->titlePlural,
            'breadcrumb' => $breadcrumb,
            'label' => $setting->getName(),
            'data' => $data,
            'actions' => $actions,
            'topActions' => $topActions,
        ]);
    }

    /** @param Router $router */
    public static function defineRoute(Router $router): void
    {
        $router->get(config('backoffice.global_url_prefix') . '/configuraciones/{key}/ver', [
            'uses' => self::class,
        ])
            ->name(self::class)
            ->middleware([Kernel::BACKOFFICE]);
    }

    public static function route(string $key)
    {
        return route(self::class, ['key' => $key]);
    }
}
