@extends('layout.app')

@section('content')

    <div class="mb-3">
        <a class="btn btn-link" href="/price-list/{{ $priceList->id }}">Назад</a>
    </div>

    <h1>Редактирование прайслиста "{{ $priceList->name }}"</h1>

    <form action="/price-list/{{ $priceList->id }}/edit" method="post" class="mt-5 mb-3">
        @csrf

        @include('layout.input', [
            'title' => 'Название',
            'name'  => 'name',
            'type'  => 'text',
            'value' => old('name', $priceList->name),
        ])

        @include('layout.input', [
            'title' => 'Поставщик',
            'name'  => 'provider',
            'type'  => 'text',
            'value' => old('provider', $priceList->provider),
        ])

        @include('layout.input', [
            'title' => 'Срок действия',
            'name'  => 'validity_period',
            'type'  => 'date',
            'value' => old('validity_period', $priceList->validity_period->format('Y-m-d')),
        ])

        @include('layout.input', [
            'title' => 'Валюта',
            'name'  => 'currency',
            'type'  => 'text',
            'value' => old('currency', $priceList->currency),
        ])

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </div>
    </form>


@endsection
