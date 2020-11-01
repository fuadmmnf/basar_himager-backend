<html>
<head>
    <title>Gate Pass</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'kalpurush', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th, td {
            padding: 7px;
            font-family: 'kalpurush', sans-serif;
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

        @page {
            header: page-header;
            footer: page-footer;
            {{--background: url({{ public_path('images/background_demo.png') }});--}}
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
</head>
<body>
<span align="center" style="line-height: 1.2;">
    <p style="font-size: 1.4rem; font-weight: bold">Gate Pass</p>
    <p><b>Recive No:</b> {{$gatepassInfo->gatepass_no}}</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>Client</h3>
                <div>
                    <p>Name: {{$gatepassInfo->delivery->booking->client->name}}</p>
                    <p>Phone: {{$gatepassInfo->delivery->booking->client->phone}}</p>
                    <p>Father's Name: {{$gatepassInfo->delivery->booking->client->father_name}}</p>

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
                <h3>Booking Information</h3>
                <div>
                    <p>No: {{$gatepassInfo->delivery->booking->booking_no}}</p>
                    <p>Date: {{$gatepassInfo->delivery->booking->booking_time}}</p>
                    <p>Total Quantity: {{$gatepassInfo->delivery->booking->quantity}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <div>
                <h3>Receive Information</h3>
                <div>
                    <p>Quantity: {{$gatepassInfo->delivery->quantity_bags}}</p>
                    <p>Time: {{$gatepassInfo->delivery->delivery_time}}</p>
                    <p>Potato Type: {{$gatepassInfo->delivery->potatoe_type}}</p>
                </div>
            </div>
        </td>
    </tr>

</table>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>GatePas Information</h3>
                <div>
                    <p>No: {{$gatepassInfo->gatepass_no}}</p>
                    <p>Time: {{$gatepassInfo->gatepass_time}}</p>
{{--                    <p>Transport: {{$gatepassInfo->transport}}</p>--}}
                </div>
            </div>
        </td>
    </tr>
</table>


<htmlpageheader name="page-header">

</htmlpageheader>


<htmlpagefooter name="page-footer">


</htmlpagefooter>
</body>
</html>
