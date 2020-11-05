<html>
<head>
    <title>Download Booking Receipt</title>
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
    <p style="font-size: 1.4rem; font-weight: bold">Booking Receipt</p>
    <p><b>Booking No:</b> {{$bookinginfo->booking_no}}</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>Client</h3>
                <div>
                    <p>Name: {{$bookinginfo->client->name}}</p>
                    <p>Phone: {{$bookinginfo->client->phone}}</p>
                    <p>Father's Name: {{$bookinginfo->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>

</table>

<table>
    <tr>
        <td style="width: 70%; text-align: left">
            <div   >
                <h3>Booking Information</h3>
                <div>
                    <p>No: {{$bookinginfo->booking_no}}</p>
                    <p>Date: {{$bookinginfo->booking_time}}</p>
                    <p>Total Quantity: {{$bookinginfo->quantity}}</p>
                    <p>Bags In: {{$bookinginfo->bags_in}}</p>
                </div>
            </div>
        </td>
        <td  class="td-right-align" style="width: 30%; text-align: left">
            <div>
                <p>Total Amount:</p>
                <p>Advance Payment: {{$bookinginfo->advance_payment}}</p>
                <p>Discount: {{$bookinginfo->discount}} %</p>
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
