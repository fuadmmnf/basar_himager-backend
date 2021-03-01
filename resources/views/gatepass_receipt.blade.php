<html>
<head>
    <title>Gate Pass</title>
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
<br />

<div style="text-align: center">
    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br />
    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br /> <br/>

    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">
        <b style="font-size: 1.6rem;padding: 20px">গেট পাস</b> <br />

    </div>

</div>



<div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>গেট পাসের তথ্য</b></span>
</div>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
                <div>
                    <p><b>গেট পাস নং:</b> {{$gatepassInfo->gatepass_no}}</p>
                    <p><b>দেলিভারী নং:</b> {{$gatepassInfo->deliverygroup->delivery_no}}</p>
                    <p><b>সময়:</b> {{ date('F d, Y', strtotime($gatepassInfo->gatepass_time)) }}</p>
                </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <div>
                <p><b>পরিবহনের ধরন:</b> {{$gatepassInfo->transport['type']}}</p>
                <p><b>পরিবহনের নম্বর:</b> {{$gatepassInfo->transport['number']}}</p>
            </div>
        </td>
    </tr>
</table>

@if(count($gatepassInfo->deliverygroup->deliveries))
<div style="margin-top: 10px; text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>গ্রাহকের তথ্য</b></span>
</div>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div>
                <div>
                    <p><b>নাম:</b> {{$gatepassInfo->deliverygroup->deliveries[0]->booking->client->name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <p><b>ফোন নম্বর:</b> {{$gatepassInfo->deliverygroup->deliveries[0]->booking->client->phone}}</p>
        </td>
    </tr>

</table>
@endif

<div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>ডেলিভারি তথ্য</b></span>
</div>

<table class="bordertable">
    <thead>
        <tr>
            <th>আলুর ধরন</th>
            <th>SR/লট তালিকা</th>
            <th>পরিমাণ(ব্যাগ)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gatepassInfo->deliverygroup->potato_list as $potatoe_type=>$quantity)
            <tr>
                <td>{{$potatoe_type}}</td>
                <td>{{ implode(", ", $gatepassInfo->deliverygroup->lot_list[$potatoe_type]) }}</td>
                <td>{{$quantity}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td>{{array_sum($gatepassInfo->deliverygroup->potato_list)}}</td>
        </tr>
    </tbody>
</table>

<div class="footer">
    <table >
        <tr>
            <td width="50%">
                <div>
                    <hr style="width: 60%"/>
                    <b>গ্রাহক</b>
                </div>

            </td>
            <td>
                <div>
                    <hr style="width: 60%"/>
                    <b>কর্তিপক্ষ</b>
                </div>

            </td>
        </tr>
    </table>


</div>

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
