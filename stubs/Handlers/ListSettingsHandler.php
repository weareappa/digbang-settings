<?php

namespace App\Http\Backoffice\Handlers\Settings;

use App\Http\Backoffice\Handlers\Dashboard\DashboardHandler;
use App\Http\Backoffice\Handlers\Handler;
use App\Http\Kernel;
use App\Http\Utils\RouteDefiner;
use Cake\Chronos\Chronos;
use Digbang\Backoffice\Listings\Listing;
use Digbang\Security\Exceptions\SecurityException;
use Digbang\Settings\Repositories\SettingsRepository;
use Digbang\Utils\PaginationData;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;

class ListSettingsHandler extends Handler implements RouteDefiner
{
    /**
     * @var array
     */
    private $sortings = [
        'key' => 's.key',
        'name' => 's.name',
    ];

    public function __invoke(SettingsRepository $repository, Request $request)
    {
        $titlePlural = trans('settings::common.settings');

        $list = $this->getListing();

        $this->buildFilters($list);

        $this->buildListActions($list);

        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $paginationData = $this->createPaginationData($limit, $page);

        $settings = $repository->search($request->only(['key', 'name']), $this->getSorting($request),
            $paginationData->getLimit(), $paginationData->getPage());

        $list->fill($settings);

        $breadcrumb = backoffice()->breadcrumb([
            trans('backoffice::default.home') => DashboardHandler::route(),
            $titlePlural,
        ]);

        return view()->make('backoffice::index', [
            'title' => $titlePlural,
            'list' => $list,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    public static function defineRoute(Router $router): void
    {
        $router->get(config('backoffice.global_url_prefix') . '/configuraciones', [
            'uses' => self::class,
        ])
            ->name(self::class)
            ->middleware([Kernel::BACKOFFICE]);
    }

    public static function route()
    {
        return route(self::class);
    }

    /**
     * @return Listing
     */
    protected function getListing()
    {
        Chronos::setToStringFormat(trans('backoffice::default.datetime_format'));

        $listing = backoffice()->listing([
            'key' => trans('settings::common.key'),
            'name' => trans('settings::common.name'),
            'description' => trans('settings::common.description'),
            'value' => trans('settings::common.value'),
        ]);

        $listing->columns()->sortable(array_keys($this->sortings));

        $listing->addValueExtractor('value', function ($setting) {
            return (string) $setting;
        });

        return $listing;
    }

    protected function buildFilters(Listing $list)
    {
        $filters = $list->filters();

        $filters->text('key', trans('settings::common.key'), ['class' => 'form-control']);
        $filters->text('name', trans('settings::common.name'), ['class' => 'form-control']);
    }

    protected function buildListActions(Listing $list)
    {
        $rowActions = backoffice()->actions();

        // View icon
        $rowActions->link(function (Collection $row) {
            try {
                return url(ShowSettingsHandler::route($row->get('key')));
            } catch (SecurityException $e) {
                return false;
            }
        },
            fa('eye'),
            ['data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => trans('backoffice::default.show')]
        );

        // Edit icon
        $rowActions->link(function (Collection $row) {
            try {
                return url(EditSettingsFormHandler::route($row->get('key')));
            } catch (SecurityException $e) {
                return false;
            }
        },
            fa('edit'), [
                'class' => 'text-success',
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => trans('backoffice::default.edit'),
            ]
        );

        $list->setRowActions($rowActions);
    }

    private function getSorting(Request $request)
    {
        $sortBy = $request->input('sort_by') ?: 'key';
        $sortSense = $request->input('sort_sense') ?: 'asc';

        return [
            $this->sortings[$sortBy] => $sortSense,
        ];
    }

    private function createPaginationData($limit, $page): PaginationData
    {
        if ($limit == '') {
            $limit = null;
            $page = 1;
        }

        return new PaginationData($limit, $page);
    }
}
