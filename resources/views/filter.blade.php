<form method="get" class="mt-5 mb-5">
    <fieldset>
        <legend>Актуализировать данные на момент времени</legend>
        <div class="row">
            <div class="col-md-3">
                @include('layout.input', [
                            'title' => '',
                            'name'  => 'actuality_date',
                            'type'  => 'datetime-local',
                            'labelClass' => '',
                            'inputClass' => '',
                            'value' => old('actuality_date', $request->get('actuality_date', date('Y-m-d\TH:i'))),
                ])
            </div>
            <div class="col-md-3 mb-3" >
                <div class="form-check">
                    <input name="delay" @checked($request->get('delay', false)) class="form-check-input" type="checkbox" id="gridCheck1">
                    <label class="form-check-label" for="gridCheck1">
                        Отобразить просроченные прайслисты
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-1 text-md-end">
                <button type="submit" class="btn btn-outline-primary mb-3">Получить актуальный список прайслистов на дату</button>
                <a href="?" class="btn btn-outline-secondary mb-3">Сбросить</a>
            </div>
        </div>
    </fieldset>
</form>
