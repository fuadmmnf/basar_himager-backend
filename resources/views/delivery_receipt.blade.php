<html>
<head>
    <title>Download Delivery Receipt</title>
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
    <p style="font-size: 1.4rem; font-weight: bold">Delivery Receipt</p>
    <p><b>Receipt No:</b> {{$receiptinfo->delivery_no}}</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>Client</h3>
                <div>
                    <p>Name: {{$receiptinfo->booking->client->name}}</p>
                    <p>Phone: {{$receiptinfo->booking->client->phone}}</p>
                    <p>Father's Name: {{$receiptinfo->booking->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>

</table>
<div style="text-align: center">
    <span><b>Booking Information</b></span>
</div>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <div>
                    <p>No: {{$receiptinfo->booking->booking_no}}</p>
                    <p>Total Quantity: {{$receiptinfo->booking->quantity}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <div>
                <p>Date: {{$receiptinfo->booking->booking_time}}</p>
                <p>Bag Received: {{$receiptinfo->booking->bags_in}}</p>

            </div>
        </td>
    </tr>

</table>

<div style="text-align: center; padding-bottom: 10px">
    <span><b>Delivery Information</b></span>
</div>

<table class="bordertable">
    <thead>
        <tr>
            <th>Description</th>
            <th>Number of Bags</th>
            <th>Cost per Bag</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Type: {{$receiptinfo->potatoe_type}}</td>
            <td>{{$receiptinfo->quantity_bags}}</td>
            <td>{{$receiptinfo->cost_per_bag}}</td>
            <td>{{$receiptinfo->quantity_bags * $receiptinfo->cost_per_bag}}</td>
        </tr>
        <tr>
            <td>Fanned Bags</td>
            <td>{{$receiptinfo->quantity_bags_fanned}}</td>
            <td>{{$receiptinfo->fancost_per_bag}}</td>
            <td>{{$receiptinfo->quantity_bags_fanned * $receiptinfo->fancost_per_bag}}</td>
        </tr>
        <tr>
            <td>Due Charge</td>
            <td></td>
            <td></td>
            <td>{{$receiptinfo->due_charge}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><b>Total</b></td>
            <td>{{$receiptinfo->quantity_bags * $receiptinfo->cost_per_bag +
                    $receiptinfo->quantity_bags_fanned * $receiptinfo->fancost_per_bag+
                    $receiptinfo->due_charge}}
            </td>
        </tr>
    </tbody>



</table>


<htmlpageheader name="page-header">

</htmlpageheader>


<htmlpagefooter name="page-footer">


</htmlpagefooter>
</body>
</html>
