<html>
<head>
    <title>Loan Disbursement Report</title>
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
        <b style="font-size: 1.3rem;padding: 20px">লোন বিতরণের রিপোর্ট</b> <br />

    </div>

</div>
<span align="center" style="line-height: 1.2;">
    <p><b>লোন বিতরণের নং:</b> {{$loandisbursement->loandisbursement_no}}</p>
    <p><b>তারিখ:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div  >
                <h3>গ্রাহকের তথ্য</h3>
                <div>
                    <p><b>নাম:</b> {{$loandisbursement->booking->client->name}}</p>
                    <p><b>ফোন নম্বর:</b> {{$loandisbursement->booking->client->phone}}</p>
                    <p><b>বাবার নাম:</b> {{$loandisbursement->booking->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>

</table>


<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>বুকিং তথ্য</h3>
                <br>
                <div>
                    <p><b>বুকিং নম্বর:</b> {{$loandisbursement->booking->booking_no}}</p>
                    <p><b>বুকিং ধরন:</b>
                        @if($loandisbursement->booking->type == 0)
                            Normal
                        @elseif($loandisbursement->booking->type == 1)
                            Advance
                        @endif
                    </p>

                    @if($loandisbursement->booking->advance_payment > 0)
                        <p><b>অগ্রীম পরিশোধ:</b> {{$loandisbursement->booking->advance_payment}}</p>
                    @elseif($loandisbursement->booking->booking_amount > 0)
                        <p><b>বুকিং মানি:</b> {{$loandisbursement->booking->booking_amount}}</p>
                    @endif
                    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($loandisbursement->booking->booking_time)) }}</p>
                    <p><b>মোট পরিমাণ:</b> {{$loandisbursement->booking->quantity}}</p>
                    <p><b>অবশিষ্ট :</b> {{$loandisbursement->booking->quantity - $loandisbursement->booking->bags_in}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <div>
                <h3>লোন বিবরণ</h3>
                <br>
                <div>
                    <p><b>লোন বিতরণের নং:</b> {{$loandisbursement->loandisbursement_no}}</p>
                    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($loandisbursement->payment_date)) }}</p>
                    <p><b>লোনের পরিমান:</b> {{$loandisbursement->amount}}</p>
                    <p><b>পরিশোধ করতে হবে:</b> {{$loandisbursement->amount_left}}</p>
                </div>
            </div>
        </td>
    </tr>

</table>

<div style="text-align: center; color: darkblue">
    <h3>লোন সংগ্রহ </h3>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>সংগ্রহের নং</th>
        <th>তারিখ</th>
        <th>সারচার্জ</th>
        <th>পরিমান</th>
    </tr>

    </thead>
    <tbody>
    @if(count($loandisbursement->loancollections))
        @foreach($loandisbursement->loancollections as $collection)
            <tr>
                <td>{{$collection->loancollection_no}}</td>
                <td>{{$collection->payment_date}}</td>
                <td>{{$collection->surcharge}}</td>
                <td>{{$collection->payment_amount}}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td> <b>SUBTOTAL:</b></td>
            <td> <b>{{$loandisbursement->loancollections->sum('surcharge')}}</b></td>
            <td> <b>{{$loandisbursement->loancollections->sum('payment_amount')}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td> <b>TOTAL:</b></td>
            <td><b>{{$loandisbursement->loancollections->sum('surcharge')+ $loandisbursement->loancollections->sum('payment_amount')}} </b></td>
        </tr>
    @endif
    </tbody>
</table>

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
