@extends('layout.app')

@section('content')

    <div class="mb-3">
        <a class="btn btn-link" href="/price-list/{{ $priceListItem->priceList->id }}">Назад</a>
    </div>

    <h1>Редактирование "{{ $priceListItem->name }}"</h1>

    <form method="post" class="mt-5 mb-3">
        @csrf

        @include('layout.input', [
            'title' => '',
            'name'  => 'price_list_id',
            'type'  => 'hidden',
            'value' => old('price_list_id', $priceListItem->price_list_id),
        ])

        @include('layout.input', [
            'title' => 'Название',
            'name'  => 'name',
            'type'  => 'text',
            'value' => old('name', $priceListItem->name),
        ])

        @include('layout.input', [
            'title' => 'Артикул',
            'name'  => 'article_number',
            'type'  => 'text',
            'value' => old('article_number', $priceListItem->article_number),
        ])

        @include('layout.input', [
            'title' => 'Цена ('.$priceListItem->priceList->currency.')',
            'name'  => 'price',
            'type'  => 'number',
            'step'  => 'any',
            'value' => old('price', $priceListItem->price),
        ])

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </div>
    </form>


@endsection
