@extends('layouts/app')

@section('title-block') Табулеграмма @endsection

@section('page-title')
    <x-page-title>
        <div class="noprint">Табулеграмма</div>
    </x-page-title>
@endsection

@section('content')
    <div class="container">
        <div class=" mb-3 noprint">
            @if($dates)
                <h3>Выберите период</h3>
                <form   class="w-100 d-flex align-content-center" action="{{route('tabulagram.show')}}" type="get">
                    <div class="w-50">
                        <x-form.select
                            :options=$dates
                            dfvalue="{{request()->get('c_month')}}"
                            name="c_month"
                        />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mt-3 mx-3">Применить</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-warning mt-3 mx-3" onclick="window.print()">Печать</button>
                    </div>
                </form>
            @endif
        </div>

        <div id="printarea">
            @if($r_head)
            <div class="r_head">
                <h5>Организация: {{$r_head->Organization ?? ''}}</h5>
                <p>Расчетный листок за {{$r_head->r_date ?? ''}}</p>
                <div class="row">
                    <div class="col-6">
                        <p><b>{{$r_head->FIO ?? ''}} ({{ $r_head->SHIFR_SOTR ?? '' }})</b></p>
                        <p>Организация: {{$r_head->Organization ?? ''}}</p>
                        <p>Подразделение: {{$r_head->Name_Dep ?? ''}}</p>
                    </div>
                    <div class="col-6">
                        <p><b> К выплате: {{$r_head->ToPaySalaries ? number_format($r_head->ToPaySalaries, 2, ',', ' ') : ''}}</b></p>
                        <p> Должность: {{$r_head->shtat_name ?? ''}} {{$r_head->kval ?? ''}}</p>
                        <p> Оклад(тариф): {{$r_head->Tariff ? number_format($r_head->Tariff, 2, ',', ' ') : ''}}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($r_list)
                <div class="row">
                @if(!empty($r_list['Начислено']))
                    <div class="col-8">
                        <table class="table  table-bordered">
                            <thead>
                            <tr class="text-center  align-middle">
                                <th scope="col" rowspan="2" class="text-left">Вид</th>
                                <th scope="col" rowspan="2"  style="min-width: 105px;">Период</th>
                                <th scope="col" colspan="2">Рабочие </th>
                                <th scope="col"  rowspan="2">Оплачено</th>
                                <th scope="col"  rowspan="2"  style="min-width: 105px;">Сумма</th>
                            </tr>
                            <tr class="text-center  align-middle">
                                <th scope="col">Дни</th>
                                <th scope="col">Часы</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row" colspan="5">
                                    {{ $r_list['Начислено']['tip'] }}:
                                </th>
                                <th>{{ $r_list['Начислено']['summa'] ? number_format($r_list['Начислено']['summa'], 2, ',', ' ') : '' }}</th>
                            </tr>
                            @if($r_list['Начислено']['items'])
                                @php
                                    $post = $r_list['Выплачено']['items'][0]->execpost;
                                @endphp
                                @foreach($r_list['Начислено']['items'] as $item)

                                    @if ($post <> $item->execpost)

                                        @php
                                            $post = $item->execpost;
                                        @endphp
                                        <tr>
                                            <td colspan="6"><i> {{$item->execpost ?? ''}} </i></td>

                                        </tr>

                                    @else
                                    <tr>
                                        <td> {{$item->payroll ?? ''}}</td>
                                        <td> {{$item->period ?? ''}}</td>
                                        <td>{{$item->workDay ?? ''}}</td>
                                        <td>{{$item->workHour ?? ''}}</td>
                                        <td>{{$item->paid ?? ''}}</td>
                                        <td>{{$item->summa ? number_format($item->summa , 2, ',', ' ') : ''}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                @endif
                    <div class="col-4">
                        @if(!empty($r_list['Удержано']) ||  !empty($r_list['Выплачено']))

                            <table class="table  table-bordered">
                                <thead>
                                <tr class="text-center  align-middle">
                                    <th scope="col" rowspan="2" class="text-left">Вид</th>
                                    <th scope="col" rowspan="2" style="min-width: 105px;">Период</th>
                                    <th scope="col"  rowspan="2" style="min-width: 105px;">Сумма</th>
                                </tr>
                                <tr class="text-center  align-middle">

                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($r_list['Удержано']))
                                    <tr>
                                        <th scope="row" colspan="2">
                                            {{ $r_list['Удержано']['tip'] }}:
                                        </th>

                                        <th>{{ $r_list['Удержано']['summa'] ? number_format($r_list['Удержано']['summa'], 2, ',', ' ') : '' }}</th>
                                    </tr>
                                    @if($r_list['Удержано']['items'])
                                        @foreach($r_list['Удержано']['items'] as $item)
                                            <tr>
                                                <td> {{$item->payroll ?? ''}}</td>
                                                <td> {{$item->period ?? ''}}</td>
                                                <td>{{$item->summa ? number_format($item->summa , 2, ',', ' ') : ''}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif

                                @if(!empty($r_list['Выплачено']))
                                    <tr>
                                        <th scope="row" colspan="2">
                                            {{ $r_list['Выплачено']['tip'] }}:
                                        </th>

                                        <th>{{ $r_list['Выплачено']['summa'] ? number_format($r_list['Выплачено']['summa'], 2, ',', ' ') : '' }}</th>
                                    </tr>
                                    @if($r_list['Выплачено']['items'])

                                        @foreach($r_list['Выплачено']['items'] as $item)

                                                <tr>
                                                    <td> {{$item->payroll ?? ''}}</td>
                                                    <td> {{$item->period ?? ''}}</td>
                                                    <td>{{$item->summa ? number_format($item->summa , 2, ',', ' ') : ''}}</td>
                                                </tr>


                                        @endforeach
                                    @endif
                                @endif
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>


                @if(!empty($r_list['Справочно']))
                    <div class="row">
                        <div class="col-4">
                            <table class="table  table-bordered">
                                <thead>
                                <tr class="text-center  align-middle">
                                    <th scope="col" >Справочно</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($r_list['Справочно']['items'])
                                    @foreach($r_list['Справочно']['items'] as $item)
                                        <tr>
                                            <td> {{$item->payroll ?? ''}}</td>
                                            <td>{{$item->summa ? number_format($item->summa , 2, ',', ' ') : ''}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                @endif

            @endif

            @if($r_footer)
                <div class="row">
                    <div class="col-6">
                        @if($r_footer->dedProperty <> 0)
                            <p>Вычет имущественный: {{$r_footer->dedProperty ? number_format($r_footer->dedProperty , 2, ',', ' ') : ''}}</p>
                        @endif

                        @if($r_footer->debChild <> 0)
                            <p>Вычет на детей: {{$r_footer->debChild ? number_format($r_footer->debChild , 2, ',', ' ') : ''}} </p>
                        @endif

                        @if($r_footer->TaxableIncome <> 0)
                            <p>Облагаемый  доход: {{$r_footer->TaxableIncome ? number_format($r_footer->TaxableIncome , 2, ',', ' ') : ''}}</p>
                        @endif


                    </div>
                    <div class="col-6">
                        @if($r_footer->dedSocial <> 0)
                            <p>Вычет cоциальный: {{$r_footer->dedSocial ? number_format($r_footer->dedSocial , 2, ',', ' ') : ''}} </p>
                        @endif
                        @if($r_footer->dedPersonal <> 0)
                            <p>Вычет личный: {{$r_footer->dedPersonal ? number_format($r_footer->dedPersonal , 2, ',', ' ') : ''}} </p>
                        @endif


                        @if($r_footer->InsuranceContrib <> 0)
                            <p>Страховые взносы ПФР: {{$r_footer->InsuranceContrib ? number_format($r_footer->InsuranceContrib , 2, ',', ' ') : ''}} </p>
                        @endif

                        @if($r_footer->AdvancePayments <> 0)
                            <p>Авансовые платежи: {{$r_footer->AdvancePayments ? number_format($r_footer->AdvancePayments , 2, ',', ' ') : ''}}  </p>
                        @endif


                    </div>
                </div>

            @endif
        </div>

    </div>
@endsection

