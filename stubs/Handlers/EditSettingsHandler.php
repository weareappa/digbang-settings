<?php

namespace App\Http\Backoffice\Handlers\Settings;

use App\Http\Backoffice\Handlers\Handler;
use App\Http\Kernel;
use App\Http\Utils\RouteDefiner;
use Cake\Chronos\Chronos;
use Digbang\Security\Exceptions\SecurityException;
use Digbang\Settings\Entities\ArraySetting;
use Digbang\Settings\Entities\BooleanSetting;
use Digbang\Settings\Entities\DateSetting;
use Digbang\Settings\Entities\DateTimeSetting;
use Digbang\Settings\Entities\FloatSetting;
use Digbang\Settings\Entities\IntSetting;
use Digbang\Settings\Entities\StringSetting;
use Digbang\Settings\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class EditSettingsHandler extends Handler implements RouteDefiner
{
    public function __invoke(Request $request, string $key, SettingsRepository $repository)
    {
        $setting = $repository->get($key);
        $value = $request->input('value');

        if ($request->input('null', false)) {
            $value = null;
        } else {
            switch (true) {
                case $setting instanceof ArraySetting:
                    $value = explode(',', $value);
                    break;
                case $setting instanceof BooleanSetting:
                    $value = (bool) filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    break;
                case $setting instanceof IntSetting:
                    $value = (int) $value;
                    break;
                case $setting instanceof FloatSetting:
                    $value = (float) $value;
                    break;
                case $setting instanceof DateSetting:
                case $setting instanceof DateTimeSetting:
                    $value = Chronos::parse($value);
                    break;
                case $setting instanceof StringSetting:
                default:
            }
        }

        try {
            $repository->setValue($key, $value);

            return redirect(ListSettingsHandler::route())->with([
                'success' => 'La configuración ha sido modificada.',
            ]);
        } catch (SecurityException $e) {
            return redirect()->back()->withInput()->with([
                'danger' => $e->getMessage(),
            ]);
        } catch (\Exception $exception) {
            logger()->error($exception);

            return back()->withInput()->with('danger', 'Ha ocurrido un error inesperado');
        }
    }

    /** @param Router $router */
    public static function defineRoute(Router $router): void
    {
        $router->post(config('backoffice.global_url_prefix') . '/configuraciones/{key}', [
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
