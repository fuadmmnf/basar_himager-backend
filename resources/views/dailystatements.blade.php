<html>
<head>
    <title>Daily Statement Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Kalpurush', 'AdorshoLipi', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th, td {
            font-family: 'Kalpurush', 'AdorshoLipi', sans-serif;
            font-size: 15px;
        }

        .bordertable td, th {
            border: 1px solid black;
        }

        .present {
            color: #218838;
        }

        .absent {
            color: #F03A17;
        }

        .storeWaterMark {
            text-align: center;
            font-size: 30px;
            color: #b8cee3;
            opacity: 0.1 !important;
        }

        .footer {
            position: fixed;
            bottom: 20px;
        }

        @page {
            header: page-header;
            footer: page-footer;
            background: url({{ public_path('images/bhl_bg2.png') }});
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
</head>
<body>
<br/>

<div style="text-align: center">
    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br/>
    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br/> <br/>

    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">
        <b style="font-size: 1.6rem;padding: 20px">দৈনিক আলু ডেলিভারী প্রতিবেদন</b> <br/>

    </div>

</div>
<br>

<div>
    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($start_date)) }}</p>
</div>
<table class="bordertable">
    <thead>
    <tr>
        <th>বুকিং নং</th>
        <th>ডি ও নং</th>
        <th>এস আর নং</th>
        <th>লট সংখ্যা</th>
        <th>বস্তার সংখ্যা</th>
        <th>সাধারণ বস্তা</th>
        <th>সাধারণ ভাড়া</th>
        <th>অগ্রিম বস্তা</th>
        <th>খালি বস্তার দাম</th>
        <th>ডি ও চার্জ</th>
{{--        <th>ফ্যান ভাড়া</th>--}}
        <th>টাকা</th>
        <th>লোন</th>
        <th>লোনের সার চার্জ</th>
        <th>মোট ফ্যান বস্তা</th>
        <th>মোট ফ্যান চার্জ</th>
        <th>মোট টাকা</th>

    </tr>
    </thead>
    <tbody>
    @if(count($statements))
        @php
            $totalNormalBags = 0;
            $totalAdvanceBags = 0;
            $totalAmount = 0;
        @endphp

        @foreach($statements as $statement)
            @if($statement->type ==1)
                <tr>
                    <td>{{$statement->loancollection->loandisbursement->booking->booking_no}}</td>
                    <td>{{$statement->delivery_no}}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        @php
                            $total_loan = 0;
                            $surcharge = 0;
                            foreach ($statement->loancollection as $loan){
                                $total_loan += $loan->payment_amount;
                                $surcharge += $loan->surcharge;
                            }
                        @endphp
                        {{$total_loan}}
                    </td>
                    <td>{{$surcharge}}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $total_loan + $surcharge}}</td>

                </tr>
            @else
                @foreach($statement->deliveries as $delivery)
                    @foreach($delivery->deliveryitems as $deliveryitem)
                        <tr>
                            @if($loop->index == 0)
                                <td rowspan="{{count($delivery->deliveryitems)}}">{{$delivery->booking->booking_no}}</td>
                                <td rowspan="{{count($delivery->deliveryitems)}}">{{$statement->delivery_no}}</td>
                            @endif
                            <td>
                                @php
                                    $sr_lot = explode("/", $deliveryitem->srlot_no);
                                @endphp
                                {{$sr_lot[0]}}
                            </td>
                            <td>{{$sr_lot[1]}}</td>
                            <td>{{$deliveryitem->quantity}}</td>

                            <td>
                                @if($delivery->booking->type == 0)
                                    {{$deliveryitem->quantity}}
                                    @php
                                        $totalNormalBags += $deliveryitem->quantity;
                                    @endphp

                                @else
                                    -
                                @endif
                            </td>
                            <td>@if($delivery->booking->booking_no[0] == 'N')
                                    {{($delivery->cost_per_bag * $deliveryitem->quantity)}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($delivery->booking->type == 1)
                                    {{$deliveryitem->quantity}}
                                    @php
                                        $totalAdvanceBags += $deliveryitem->quantity;
                                    @endphp
                                @else
                                    -
                                @endif
                            </td>

                            <td></td>
                            <td>{{$delivery->do_charge * $deliveryitem->quantity}}</td>
                            {{--                            <td>--}}
                            {{--                                {{$delivery->quantity_bags_fanned * $delivery->fancost_per_bag}}--}}
                            {{--                            </td>--}}
                            <td>{{(($delivery->cost_per_bag * $deliveryitem->quantity))+ ($delivery->do_charge * $deliveryitem->quantity) + ($delivery->quantity_bags_fanned * $delivery->fancost_per_bag)}}</td>

                            @if($loop->index == 0)
                                @php
                                    $total_loan = 0;
                                    $surcharge = 0;
                                @endphp
                                <td rowspan="{{count($delivery->deliveryitems)}}">
                                    @if($statement->deliveries[0]->id == $delivery->id)
                                        @php
                                            foreach ($statement->loancollection as $loan){
                                                $total_loan += $loan->payment_amount;
                                                $surcharge += $loan->surcharge;
                                            }
                                        @endphp

                                    @endif
                                    {{$total_loan}}
                                </td>
                                <td rowspan="{{count($delivery->deliveryitems)}}">
                                        {{$surcharge}}
                                </td>
                                    <td>-</td>
                                    <td>-</td>
                                <td rowspan="{{count($delivery->deliveryitems)}}">{{$delivery->total_charge  + ($delivery->quantity_bags_fanned * $delivery->fancost_per_bag) + $total_loan + $surcharge}}</td>
                                @php
                                    $totalAmount += ($delivery->total_charge  + ($delivery->quantity_bags_fanned * $delivery->fancost_per_bag) + $total_loan + $surcharge);
                                @endphp
                            @endif
                        </tr>
                    @endforeach
                @endforeach

            @endif
        @endforeach
        <tr>
            <td><b>মোট</b></td>
            <td colspan="3">-</td>
            <td><b>{{$totalNormalBags + $totalAdvanceBags}}</b></td>
            <td><b>{{$totalNormalBags}}</b></td>
            <td>-</td>
            <td><b>{{$totalAdvanceBags}}</b></td>
            <td colspan="5">-</td>
            <td >{{$fanChargeInfo['total_quantity_bags_fanned']}}</td>
            <td >{{$fanChargeInfo['total_amount']}}</td>
            <td><b>{{$totalAmount+$fanChargeInfo['total_amount']}}</b></td>
        </tr>
    @endif
    </tbody>
</table>


{{--<pagebreak/>--}}


<htmlpageheader name="page-header">
    <table>
        <tr>
            <td align="left" width="50%" style="padding: 0">
                <small style="font-size: 12px; color: #525659;">download time: <span
                        style="font-family: Calibri; font-size: 12px;">{{ date('F d, Y, h:i A') }}</span></small>
            </td>
            <td align="right" style="color: #525659;">
                <small>
                    | page: {PAGENO}/{nbpg}
                </small>
            </td>
        </tr>
    </table>
</htmlpageheader>


<htmlpagefooter name="page-footer">

    <table>
        <tr>
            <td width="50%" align="left" style="padding: 0">
                <div class="storeWaterMark" style="opacity: 0.1;">
                    <p>Basar Himager Limited</p>
                    {{--        @if($store->slogan)--}}
                    {{--            <br/>** {{ $store->slogan }} **--}}
                    {{--        @endif--}}
                </div>

            </td>
            <td align="right">
               <span style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Generated by:
                    https://basarhimager.com</span> <br/>
                <small style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Powered by:
                    https://innovabd.tech (01515297658)</small>
            </td>
        </tr>
    </table>

</htmlpagefooter>
</body>
</html>
