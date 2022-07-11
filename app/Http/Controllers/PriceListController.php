<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportPriceListRequest;
use App\Http\Requests\UpdatePriceListRequest;
use App\Http\Resources\PriceListResource;
use App\Models\PriceList;
use App\Models\PriceListItem;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    /**
     * Show the PriceList table
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('index', [
            'priceLists' =>  PriceList::getAtTime($request)->get(),
            'request' => $request,
            'breadcrumbs' => [
                [
                    'name' => 'Список прайслистов',
                    'href' => '/',
                    'isActive' => true,
                ],
            ]
        ]);
    }

    /**
     *  Show the PriceList.
     * @param $priceListId
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($priceListId, Request $request)
    {
        // Отношения должны относится к запрашиваемой дате актуальности
        $date = PriceList::getNeedDate($request);
        $priceList = PriceList::getAtTime($request)->with(['items' => function ($query) use($date) {
            $query->bySystemTime($date);
        }])->find($priceListId);


        return view('price-list/show', [
            'priceList' =>  $priceList,
            'request' => $request,
            'breadcrumbs' => [
                [
                    'name' => 'Список прайслистов',
                    'href' => '/',
                    'isActive' => false,
                ],
                [
                    'name' => 'Прайслист "'.$priceList->name.'"',
                    'href' => '/price-list/'.$priceList->id,
                    'isActive' => true,
                ]
            ]
        ]);
    }

    /**
     *  Edit the PriceList.
     * @param $priceListId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($priceListId)
    {

        $priceList = PriceList::find($priceListId);

        return view('price-list/edit', [
            'priceList' =>  $priceList,
            'breadcrumbs' => [
                [
                    'name' => 'Список прайслистов',
                    'href' => '/',
                    'isActive' => false,
                ],
                [
                    'name' => 'Прайслист "'.$priceList->name.'"',
                    'href' => '/price-list/'.$priceList->id,
                    'isActive' => false,
                ],
                [
                    'name' => 'Редактирование прайслиста "'.$priceList->name.'"',
                    'href' => '/price-list/'.$priceList->id.'/edit',
                    'isActive' => true,
                ]
            ]
        ]);
    }

    /**
     * Edit the PriceList
     * @param UpdatePriceListRequest $request
     * @param $priceListId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePriceListRequest $request, $priceListId)
    {
        $priceList = PriceList::with('items')->find($priceListId);

        $priceList->update($request->validated());

        // Без sleep идёт редирект на старые данные
        sleep(1);

        return to_route('price-list-show', $priceListId);
    }

    /**
     * Delete the PriceList
     * @param $priceListId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($priceListId)
    {
        $priceList = PriceList::find($priceListId);
        $priceList->delete();
        return to_route('index');
    }

    /**
     * Export PriceLists
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function export(Request $request)
    {
        return view('export', [
            'priceLists' =>  PriceList::getAtTime($request)->get(),
            'request' => $request,
            'export' => 'export',
            'breadcrumbs' => [
                [
                    'name' => 'Экспорт данных',
                    'href' => '/',
                    'isActive' => true,
                ],
            ]
        ]);
    }

    /**
     * Download PriceLists
     * @param ExportPriceListRequest $request
     * @param $priceListId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function download(ExportPriceListRequest $request)
    {
        $date = PriceList::getNeedDate($request);
        $priceList = PriceList::with(['items' => function ($query) use($date) {
            $query->bySystemTime($date);
        }])->whereIn('id',  $request->get('lists'))->get();

        return match ($request->get('format')) {
            'JSON' => '<pre>'.json_encode([
                    'export_at' => now(),
                    'actuality_date' => $request->get('actuality_date', now()),
                    'format' => 'JSON',
                    'data' => $priceList->toArray()
                ], JSON_PRETTY_PRINT).'</pre>',
            'XLSX' => PriceList::downloadXLSX($date, $priceList)
        };
    }
}
