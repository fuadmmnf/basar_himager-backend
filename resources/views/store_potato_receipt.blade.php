<html>
<head>
    <title>Potato Store Receipt</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Kalpurush', 'AdorshoLipi',  sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th, td {;
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
        <b style="font-size: 1.6rem;padding: 20px">আলু সংরক্ষণের দলিল</b> <br />

    </div>

</div>
<span align="center" style="line-height: 1.2;">
    <p style="font-size: 1.4rem; font-weight: bold">আলু সংরক্ষণের দলিল</p>
    <p><b>তারিখ:</b>{{ date('F d, Y') }}</p>
</span>
<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>গ্রাহকের তথ্য</h3>
                <br/>
                <div>
                    <p><b>গ্রাহকের নং:</b> {{$client->client_no}}</p>
                    <p><b>এন.আই.ডি:</b> {{$client->nid}}</p>
                    <p><b>নাম:</b> {{$client->name}}</p>
                    <p><b>ফোন নম্বর:</b> {{$client->phone}}</p>
                    <p><b>বাবার নাম:</b> {{$client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>
</table>
<br/>
<table class="bordertable">
        <thead>
            <tr>
                <th>বুকিং নম্বর</th>
                <th>বুকিং সময়</th>
                <th>বুকিং পরিমাণ</th>
                <th>রিসিভ নম্বর</th>
                <th>তারিখ</th>
                <th>আলুর ধরন</th>
                <th>পরিমাণ</th>
                <th>ব্যাগ নম্বর</th>
                <th>ইনভেন্টরি</th>
            </tr>
            </thead>
        <tbody>
            @if(count($client->bookings))
                @foreach($client->bookings as $booking)
                    @foreach($booking->receives as $receive)
                        @if(count($receive->loaddistributions))
                        @foreach($receive->receiveitems as $receiveitem)
                                @foreach($receive->loaddistributions as $load)
                                    @if($receiveitem->potatoe_type == $load->potato_type)
                                        <tr>
                                            <td>{{$booking->booking_no}}</td>
                                            <td>{{$booking->booking_time}}</td>
                                            <td>{{$booking->quantity}}</td>
                                            <td>{{$receive->receivegroup->receiving_no}}</td>
                                            <td>{{$receive->receivegroup->receiving_time}}</td>
                                            <td>{{$receiveitem->potatoe_type}}</td>
                                            <td>{{$receiveitem->quantity}}</td>
                                            <td>{{$load->bag_no}}</td>
                                            <td>
                                                <b>Ch: </b>{{$load->inventory->parent_info->parent_info->name}}<br/>
                                                <b>FL: </b>{{$load->inventory->parent_info->name}}<br/>
                                                <b>Co: </b>{{$load->inventory->name}}<br/>
                                                ({{$load->quantity}})
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                        @endforeach
                        @endif
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
