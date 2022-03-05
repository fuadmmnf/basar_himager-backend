<html>
<head>
    <title>Receive Wise potato store report</title>
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
        <b style="font-size: 1.6rem;padding: 20px">আলু সংরক্ষন রশিদ</b> <br />

    </div>
</div>




<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <span style="text-decoration: underline; font-size: 1.4rem">বুকিং তথ্য</span> <br/> <br/>
            <span>বুকিং নম্বরঃ {{$receives[0]->booking->booking_no}}</span> <br/>
            <span>নামঃ {{$receives[0]->booking->client->name}}</span> <br/>
            <span>ফোন নম্বরঃ {{$receives[0]->booking->client->phone}}</span> <br/>
            <span>গ্রামঃ {{$receives[0]->booking->client->address['village']}}</span>
            {{--            <div>--}}
            {{--                <div>--}}
            {{--                    <p><b>নাম:</b> {{$receiptinfo->receives[0]->booking->client->name}}</p>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <span style="text-decoration: underline; font-size: 1.4rem">গ্রাহকের তথ্য</span> <br/> <br/>
            <span style="font-size: 1.2rem; font-weight: bolder;">আলু গ্রহণ নম্বরঃ {{$receives[0]->receivegroup->receiving_no}}</span> <br/>
            <span>তারিখঃ {{ bangla(date('F d, Y', strtotime($receives[0]->receivegroup->receiving_time))) }}</span> <br/>
            <span>গ্রাহকের নামঃ {{$receives[0]->farmer_info['name']}}</span> <br/>
            <span>গ্রাহকের গ্রামঃ  {{$receives[0]->farmer_info['village']}}</span>
            {{--            <p><b>ফোন নম্বর:</b> {{$receiptinfo->receives[0]->booking->client->phone}}</p>--}}
        </td>
    </tr>

</table>

<br>

<table class="bordertable">
    <thead>
    <tr>
        <th>বুকিং নম্বর</th>
        <th>তারিখ</th>
        <th>চেম্বার</th>
        <th>ফ্লোর</th>
        <th>কম্পার্টমেন্ট</th>
        <th>আলুর ধরন </th>
        <th>পরিমাণ</th>
        <th>SR/লট নং</th>
    </tr>

    </thead>
    <tbody>
    @if(count($receives))
        @foreach($receives as $receive)
            @foreach($receive->loaddistributions as $load)
            <tr>
                <td>{{$receive->booking->booking_no}}</td>
                <td>{{$load->created_at->format('F d, Y')}}</td>
                <td>{{$load->inventory->parent_info->parent_info->name}}</td>
                <td>{{$load->inventory->parent_info->name}}</td>
                <td>{{$load->inventory->name}}</td>
                <td>{{$load->potato_type}}</td>
                <td>{{$load->quantity}}</td>
                <td>{{$receive->lot_no}}</td>
            </tr>
            @endforeach
        @endforeach
    @endif
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
