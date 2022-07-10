<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportPriceListRequest;
use App\Http\Requests\UpdatePriceListItemRequest;
use App\Models\PriceListItem;
use Illuminate\Http\Request;

class PriceListItemController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceListItem  $priceListItem
     * @return \Illuminate\Http\Response
     */
    public function edit($priceListId, $priceListItemId)
    {
        $priceListItem = PriceListItem::with('priceList')->find($priceListItemId);

        return view('price-list-item/edit', [
            'priceListItem' =>  $priceListItem,
            'breadcrumbs' => [
                [
                    'name' => 'Список прайслистов',
                    'href' => '/',
                    'isActive' => false,
                ],
                [
                    'name' => 'Прайслист "'.$priceListItem->priceList->name.'"',
                    'href' => '/price-list/'.$priceListItem->priceList->id,
                    'isActive' => false,
                ],
                [
                    'name' => 'Редактирование "'.$priceListItem->name.'"',
                    'isActive' => true,
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePriceListItemRequest  $request
     * @param  \App\Models\PriceListItem  $priceListItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePriceListItemRequest $request, $priceListId, $priceListItemId)
    {
        $priceListItem = PriceListItem::find($priceListItemId);

        $priceListItem->update($request->validated());

        // Без sleep идёт редирект на старые данные
        sleep(1);

        return to_route('price-list-show', $priceListId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceListItem  $priceListItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($priceListId, $priceListItemId)
    {
        $priceListItem = PriceListItem::find($priceListItemId);
        $priceListItem->delete();
        return to_route('price-list-show', $priceListId);
    }
}
