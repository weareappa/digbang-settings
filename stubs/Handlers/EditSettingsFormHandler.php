<?php

namespace App\Http\Backoffice\Handlers\Settings;

use App\Http\Backoffice\Handlers\Dashboard\DashboardHandler;
use App\Http\Backoffice\Handlers\Handler;
use App\Http\Kernel;
use App\Http\Utils\RouteDefiner;
use Digbang\Backoffice\Inputs\Collection;
use Digbang\Settings\Entities\ArraySetting;
use Digbang\Settings\Entities\BooleanSetting;
use Digbang\Settings\Entities\DateSetting;
use Digbang\Settings\Entities\DateTimeSetting;
use Digbang\Settings\Entities\FloatSetting;
use Digbang\Settings\Entities\IntSetting;
use Digbang\Settings\Entities\Setting;
use Digbang\Settings\Entities\StringSetting;
use Digbang\Settings\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class EditSettingsFormHandler extends Handler implements RouteDefiner
{
    /** @var string */
    protected $title = 'Configuración';

    /** @var string */
    protected $titlePlural = 'Configuraciones';

    public function __invoke(Request $request, string $key, SettingsRepository $repository)
    {
        $setting = $repository->get($key);

        $form = backoffice()->form(
            security()->url()->to(EditSettingsHandler::route($key)),
            "Editar {$this->title}"
        );

        $inputs = $form->inputs();

        $inputs->text('key', trans('settings::common.key'), ['readonly' => true]);
        $inputs->text('name', trans('settings::common.name'), ['readonly' => true]);
        $inputs->textarea('description', trans('settings::common.description'), ['readonly' => true]);

        $this->buildValueInput($inputs, $setting);

        $data = [
            'key' => $setting->getKey(),
            'name' => $setting->getName(),
            'description' => $setting->getDescription(),
            'null' => $setting->getValue() === null,
            'value' => $setting->getValue(),
        ];

        if ($setting instanceof DateSetting) {
            $data['value'] = $data['value'] ? $data['value']->toDateString() : null;
        } elseif ($setting instanceof ArraySetting) {
            $data['value'] = $data['value'] ? implode(',', $data['value']) : null;
        }

        $form->fill($data);

        $breadcrumb = backoffice()->breadcrumb([
            trans('backoffice::default.home') => DashboardHandler::route(),
            $this->titlePlural => ListSettingsHandler::class,
            trans('backoffice::default.edit'),
        ]);

        return view()->make('settings::edit', [
            'title' => $this->titlePlural,
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    /** @param Router $router */
    public static function defineRoute(Router $router): void
    {
        $router->get(config('backoffice.global_url_prefix') . '/configuraciones/{key}/editar', [
            'uses' => self::class,
        ])
            ->name(self::class)
            ->middleware([Kernel::BACKOFFICE]);
    }

    public static function route(string $key): string
    {
        return route(self::class, ['key' => $key]);
    }

    protected function buildValueInput(Collection $inputs, Setting $setting)
    {
        if ($setting->isNullable()) {
            $inputs->checkbox('null', trans('settings::common.null'));
        }

        switch (true) {
            case $setting instanceof IntSetting:
                $inputs->integer('value', trans('settings::common.value'));
                break;
            case $setting instanceof FloatSetting:
                $inputs->float('value', trans('settings::common.value'));
                break;
            case $setting instanceof ArraySetting:
                $collection = $inputs->collection();
                $collection->text('value', trans('settings::common.value'),
                    ['type' => 'hidden', 'class' => 'form-control array-setting']);
                $inputs->composite('', $collection, trans('settings::common.value'));
                break;
            case $setting instanceof DateSetting:
                $inputs->date('value', trans('settings::common.value'));
                break;
            case $setting instanceof DateTimeSetting:
                $inputs->datetime('value', trans('settings::common.value'));
                break;
            case $setting instanceof BooleanSetting:
                $inputs->boolean('value', trans('settings::common.value'));
                break;
            case $setting instanceof StringSetting:
            default:
                $inputs->text('value', trans('settings::common.value'));
                break;
        }
    }
}
