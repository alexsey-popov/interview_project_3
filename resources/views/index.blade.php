@extends('layout.app')

@section('content')
    <h1>
        Список прайслистов
        @if($request->has('actuality_date'))
            <small class="text-danger">
                (актуально на {{ date('d.m.Y H:i:s', strtotime($request->get('actuality_date'))) }})
            </small>
        @endif
    </h1>

    @include('filter')

    <table class="table table-hover">
        <thead>
        <tr>
            <td>Название</td>
            <td>Поставщик</td>
            <td>Срок действия</td>
            <td>Валюта</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @forelse($priceLists as $priceList)
            <tr @class([ 'bg-danger bg-opacity-25' => $priceList->isActual($request->get('actuality_date', date('Y-m-d'))) ])>
                <td>{{ $priceList->name }}</td>
                <td>{{ $priceList->provider }}</td>
                <td>{{ $priceList->validity_period->format('d.m.Y') }}</td>
                <td>{{ $priceList->currency }}</td>
                <td class="text-end">
                    <div class="btn-group">
                        <a class="btn btn-outline-primary"
                           href="/price-list/{{  $priceList->id }}?{{ $request->getQueryString() }}">
                            Открыть
                        </a>
                        <button type="button"
                                class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                id="dropdownMenuReference"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                data-bs-reference="parent">
                            <span class="visually-hidden">Переключатель выпадающего списка</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                            <li><a class="dropdown-item" href="/price-list/{{  $priceList->id }}?{{ $request->getQueryString() }}">Открыть</a></li>
                            @if(!$request->has('actuality_date'))
                                <li><a class="dropdown-item" href="/price-list/{{  $priceList->id }}/edit">Редартировать</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item dropdown-item-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-bs-name="{{ $priceList->name }}"
                                        data-bs-link="/price-list/{{ $priceList->id }}/delete">
                                        Удалить
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <h3 class="text-center text-secondary p-5">Нет данных</h3>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
@endsection
