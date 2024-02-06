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


<h3 style="text-align: center;">গ্রাহকের তথ্য</h3>
<table style="width: 100%;" class="bordertable">
    <tr>
        <td>
            <p><b>নাম:</b></p>
        </td>
        <td >
            <p>{{$loandisbursement->booking->client->name}}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p><b>ফোন নম্বর:</b></p>
        </td>
        <td >
            <p>{{$loandisbursement->booking->client->phone}}</p>
        </td>
    </tr>
    <tr>
        <td >
            <p><b>বাবার নাম:</b></p>
        </td>
        <td >
            <p>{{$loandisbursement->booking->client->father_name}}</p>
        </td>
    </tr>
</table>

<h3 style="text-align: center;margin-top: 10px">বুকিং তথ্য</h3>
<table style="width: 100%;" class="bordertable">
    <tr>
        <td >
            <p><b>বুকিং নম্বর:</b></p>
        </td>
        <td >
            <p>{{$loandisbursement->booking->booking_no}}</p>
        </td>
    </tr>
    <tr>
        <td >
            <p><b>বুকিং ধরন:</b></p>
        </td>
        <td >
            <p>
                @if($loandisbursement->booking->type == 0)
                    Normal
                @elseif($loandisbursement->booking->type == 1)
                    Advance
                @endif
            </p>
        </td>
    </tr>
    @if($loandisbursement->booking->advance_payment > 0)
        <tr>
            <td >
                <p><b>অগ্রীম পরিশোধ:</b></p>
            </td>
            <td >
                <p>{{$loandisbursement->booking->advance_payment}}</p>
            </td>
        </tr>
    @elseif($loandisbursement->booking->booking_amount > 0)
        <tr>
            <td >
                <p><b>বুকিং মানি:</b></p>
            </td>
            <td >
                <p>{{$loandisbursement->booking->booking_amount}}</p>
            </td>
        </tr>
    @endif
    <tr>
        <td >
            <p><b>তারিখ:</b></p>
        </td>
        <td >
            <p>{{ date('F d, Y', strtotime($loandisbursement->booking->booking_time)) }}</p>
        </td>
    </tr>
    <tr>
        <td >
            <p><b>মোট পরিমাণ:</b></p>
        </td>
        <td >
            <p>{{$loandisbursement->booking->quantity}}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p><b>অবশিষ্ট :</b></p>
        </td>
        <td>
            <p>{{$loandisbursement->booking->quantity - $loandisbursement->booking->bags_in}}</p>
        </td>
    </tr>
</table>

<h3 style="text-align: center; margin-top: 10px">লোন বিবরণ</h3>
<table style="width: 100%;" class="bordertable">
    <tr>
        <td>
            <p><b>লোন বিতরণের নং:</b></p>
        </td>
        <td>
            <p>{{$loandisbursement->loandisbursement_no}}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p><b>তারিখ:</b></p>
        </td>
        <td>
            <p>{{ date('F d, Y', strtotime($loandisbursement->payment_date)) }}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p><b>লোনের পরিমান:</b></p>
        </td>
        <td>
            <p>{{$loandisbursement->amount}}</p>
        </td>
    </tr>
    <tr>
        <td>
            <p><b>মূল পরিশোধনীয়:</b></p>
        </td>
        <td>
            <p>{{$loandisbursement->amount_left}}</p>
        </td>
    </tr>
</table>


@if(count($loandisbursement->loancollections))
<div style="text-align: center; color: darkblue">
    <h3>লোন সংগ্রহ </h3>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>ডি ও নং</th>
        <th>তারিখ</th>
        <th>দিন</th>
        <th>সারচার্জ</th>
        <th>পরিমান</th>
    </tr>

    </thead>
    <tbody>

        @foreach($loandisbursement->loancollections as $collection)
            <tr>
                <td>{{$collection->deliverygroup->delivery_no}}</td>
                <td>{{ date('F d, Y', strtotime($collection->payment_date)) }}</td>
                <td>{{ round((strtotime($collection->payment_date) - strtotime($loandisbursement->payment_date)) / 86400) }}</td>
                <td>{{$collection->surcharge}}</td>
                <td>{{$collection->payment_amount}}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td> <b>SUBTOTAL:</b></td>
            <td> <b>{{$loandisbursement->loancollections->sum('surcharge')}}</b></td>
            <td> <b>{{$loandisbursement->loancollections->sum('payment_amount')}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td> <b>TOTAL:</b></td>
            <td><b>{{$loandisbursement->loancollections->sum('surcharge')+ $loandisbursement->loancollections->sum('payment_amount')}} </b></td>
        </tr>
    </tbody>
</table>
@endif

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
