@extends('layout.app')

@section('content')

    <div class="mb-3">
        <a
            class="btn btn-link"
            href="/?{{ $request->getQueryString() }}"
        >
            Назад
        </a>
    </div>

    <h1>
        Прайслист "{{ $priceList->name }}"
    </h1>
    @if($request->has('actuality_date'))
        <h3 class="text-danger"> (версия данных актуальна на {{ date('d.m.Y H:i:s', strtotime($request->get('actuality_date'))) }})</h3>
    @endif
    @if($request->has('actuality_date'))
        <div>
            <a class="btn btn-link" href="?">Показать актуальную версию данных</a>
        </div>
    @endif
    <p class="lead mb-0">Поставщик: {{ $priceList->provider }}</p>
    <p class="lead mb-0">Срок действия:
        <span @class(['text-danger' => $priceList->isActual($request->get('actuality_date', date('Y-m-d')))])>
            {{ $priceList->validity_period->format('d.m.Y') }}
            @if($priceList->isActual($request->get('actuality_date', date('Y-m-d'))))
                <small>(прайслист просрочен)</small>
            @endif
        </span>
    </p>
    <p class="lead mb-0">Валюта: {{ $priceList->currency }}</p>

    <div class="text-end">
        @if(!$request->has('actuality_date'))
            <a class="btn btn-link" href="/price-list/{{ $priceList->id }}/edit">Редактировать прайслист</a>
            <button
                type="button"
                class="btn btn-link text-danger"
                data-bs-toggle="modal"
                data-bs-target="#deleteModal"
                data-bs-name="{{ $priceList->name }}"
                data-bs-link="/price-list/{{ $priceList->id }}/delete">
                Удалить прайслист
            </button>
        @endif
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <td>Название</td>
            <td>Артикул</td>
            <td>Цена</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($priceList->items as $priceListItem)
            <tr>
                <td>{{ $priceListItem->name }}</td>
                <td>{{ $priceListItem->article_number }}</td>
                <td>{{ $priceList->currency . ' ' . $priceListItem->price }}</td>
                <td class="text-end">
                    @if(!$request->has('actuality_date'))
                        <a href="/price-list/{{ $priceList->id }}/{{ $priceListItem->id }}/edit" class="btn btn-outline-primary">Редактировать</a>
                        <button
                            type="button"
                            class="btn btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-bs-name="{{ $priceListItem->name }}"
                            data-bs-link="/price-list/{{ $priceList->id }}/{{ $priceListItem->id }}/delete">
                            Удалить
                        </button>
                    @else
                        <button disabled class="btn btn-outline-secondary">Редактировать и удалить можно только актуальные данные </button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
