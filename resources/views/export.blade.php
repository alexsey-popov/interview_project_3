@extends('layout.app')

@section('content')
    <h1>
        Экспорт списока прайслистов
        @if($request->has('actuality_date'))
            <small class="text-danger">
                (актуально на {{ date('d.m.Y H:i:s', strtotime($request->get('actuality_date'))) }})
            </small>
        @endif
    </h1>

    @include('filter')

    @error('lists')
        <p class="text-danger" role="alert">
            {{ $message }}
        </p>
    @enderror

    <form action="/download">
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
                    <td class="">
                        <div class="form-check">
                            <input name="lists[]" @checked($request->get($priceList->id, false)) value="{{ $priceList->id }}" class="form-check-input" type="checkbox" id="gridCheck{{ $priceList->id }}">
                            <label class="form-check-label" for="gridCheck{{ $priceList->id }}">
                                Добавить с выгрузку
                            </label>
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

        @include('layout.input', [
            'title' => '',
            'name'  => 'actuality_date',
            'type'  => 'hidden',
            'value' => old('actuality_date', $request->get('actuality_date', date('Y-m-d H:i'))),
        ])

        <h5>Формат выходных данных</h5>
        <div class="btn-group" role="group" aria-label="Выбор формата данных">
            <input type="radio" class="btn-check" name="format" value="JSON" id="formatJson" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="formatJson">JSON</label>

            <input type="radio" class="btn-check" name="format" value="XLSX" id="formatXLSX" autocomplete="off">
            <label class="btn btn-outline-primary" for="formatXLSX">XLSX</label>

        </div>
        @error('format')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Выгрузить данные</button>
        </div>

    </form>
@endsection
