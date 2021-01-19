<html>
<head>
    <title>Booking Receipt</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: sans-serif, 'Kalpurush', 'AdorshoLipi';
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th, td {
            padding: 7px;
            font-family: sans-serif, 'Kalpurush', 'AdorshoLipi';
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
        <b style="font-size: 1.6rem;padding: 20px">বুকিং রশিদ</b> <br />

    </div>

</div>
<span align="center" style="line-height: 1.2;">
    <p><b>Booking No:</b> {{$bookinginfo->booking_no}}</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>Client Information</h3>
                <div>
                    <p><b>Name:</b> {{$bookinginfo->client->name}}</p>
                    <p><b>Phone:</b> {{$bookinginfo->client->phone}}</p>
                    <p><b>Father's Name</b>: {{$bookinginfo->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>

</table>
<div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>Booking Information</b></span>
</div>
<table>
    <tr>
        <td style="width: 70%; text-align: left">
            <div   >
                <div>
                    <p><b>Booking Date:</b> {{ date('F d, Y', strtotime($bookinginfo->booking_time)) }}</p>
                    <p><b>Total Quantity:</b> {{$bookinginfo->quantity}}</p>
                </div>
            </div>
        </td>
        <td  class="td-right-align" style="width: 30%; text-align: left">
            <div>
                <p><b>Booking Type:</b>
                    @if($bookinginfo->type == 0)
                        Normal
                    @elseif($bookinginfo->type == 1)
                        Advance
                    @endif
                </p>

                @if($bookinginfo->advance_payment > 0)
                    <p><b>Advance Payment:</b> {{$bookinginfo->advance_payment}}</p>
                @elseif($bookinginfo->booking_amount > 0)
                    <p><b>Booking Money:</b> {{$bookinginfo->booking_amount}}</p>
                @endif
            </div>
        </td>
    </tr>

</table>



<div class="footer">
    <table >
        <tr>
            <td width="50%">
                <div>
                    <hr style="width: 60%"/>
                    <b>Recepient</b>
                </div>

            </td>
            <td>
                <div>
                    <hr style="width: 60%"/>
                    <b>Authority</b>
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
