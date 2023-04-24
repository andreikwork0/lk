@extends('layouts/app')

@section('title-block') Отпуск @endsection

@section('page-title')
    <x-page-title>
        <div class="noprint">Отпуск</div>
    </x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class=" mb-3 noprint">
            @if($rests)

            <div>
                <button type="button" class="btn btn-warning mt-3 mx-3" onclick="window.print()">Печать</button>
            </div>

            @else
                <p>В системе не найден Ваш персональный идентификатор.</p>
                <p>Сообщите о проблеме в отдел сетей и телекоммуникаций УИТ и АСУ по адресу: пр-т Ленина, 38, каб. 146 или по телефону +7(3519)29-84-74.</p>
            @endif
        </div>
        <div id="printarea">
            @if($rests)
            <table class="table  table-bordered">
                <thead>
                <tr class="text-center  align-middle">
                    <th scope="col">Должность</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Длительность(в днях) </th>
                    <th scope="col">Работа</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rests as $rest)
                    <td>{{$rest->shtat_name ?? ''}}</td>
                    <td>{{$rest->TypeRest_Name ?? ''}}</td>
                    <td>{{$rest->Length_OnDate ?? ''}}</td>
                    <td>{{$rest->Work ?? ''}}</td>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>
@endsection
