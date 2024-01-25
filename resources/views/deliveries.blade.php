<html>
<head>
    <title>Delivery List Report</title>
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
        <b style="font-size: 1.5rem;padding: 20px">আলু ডেলিভারী প্রতিবেদন</b> <br/>

    </div>

</div>
<br>



<table>
    <tr>
        <td align="left">
            <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($start_date)) }}</p>
        </td>
        <td align="right" style="font-size: 1.2em">মোট পরিমান: {{$statements->sum(function ($statement) {
            return $statement->deliveries->sum(function ($delivery) {
                return $delivery->deliveryitems->sum('quantity');
            });
        })
    }} বস্তা</td>
    </tr>

</table>

<div>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>তারিখ</th>
        <th>বুকিং নং</th>
        <th>ডি ও নং</th>
        <th>এস আর/লট সংখ্যা</th>
        <th>সংগ্রহকৃত পরিমান</th>
        <th>শেষ অবস্থান</th>
        <th>টাকা</th>
        <th>লোন</th>
        <th>লোনের সার র্চাজ</th>
        <th>মোট টাকা</th>
    </tr>
    </thead>
    <tbody>
    @if(count($statements))
        @foreach($statements as $statement)
            @foreach($statement->deliveries as $delivery)
                @foreach($delivery->deliveryitems as $deliveryitem)
                    <tr>
                        @if($loop->index == 0)
                            <td rowspan="{{count($delivery->deliveryitems)}}">{{ date('F d, Y', strtotime($statement->delivery_time))}}</td>
                            <td rowspan="{{count($delivery->deliveryitems)}}">{{$delivery->booking->booking_no}}</td>
                            <td rowspan="{{count($delivery->deliveryitems)}}">{{$statement->delivery_no}}</td>
                        @endif
                        <td>{{$deliveryitem->srlot_no}}</td>
                        <td>{{$deliveryitem->quantity}}</td>
                        <td>
                            @if( count($deliveryitem->unloadings))
                                Compartment: {{$deliveryitem->unloadings[0]->loaddistribution->inventory_tree->name}}
                                <br/>
                                Floor: {{$deliveryitem->unloadings[0]->loaddistribution->inventory_tree->parent_info->name}}
                                <br/>
                                Chamber: {{$deliveryitem->unloadings[0]->loaddistribution->inventory_tree->parent_info->parent_info->name}}
                            @endif
                        </td>
                        <td>{{($delivery->cost_per_bag * $deliveryitem->quantity) + ($delivery->do_charge*$deliveryitem->quantity)}}</td>

                        @if($loop->index == 0)
                                @php
                                    $total_loan = 0;
                                    $surcharge = 0;
                                @endphp


                                <td rowspan="{{count($delivery->deliveryitems)}}">
                                    @if($statement->deliveries[0]->id == $delivery->id)
                                        @php
                                            foreach ($statement->loancollections as $loan){
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
                            <td rowspan="{{count($delivery->deliveryitems)}}">{{$delivery->total_charge + $total_loan + $surcharge}}</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        @endforeach
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
