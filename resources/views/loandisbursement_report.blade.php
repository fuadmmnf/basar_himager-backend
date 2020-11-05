<html>
<head>
    <title>Download Loan Disbursement Report</title>
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
    <p style="font-size: 1.4rem; font-weight: bold">Loan Disbursement Report</p>
    <p><b>Disbursement No:</b> {{$loandisbursement->loandisbursement_no}}</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div  >
                <h3>Client Information</h3>
                <div>
                    <p>Name: {{$loandisbursement->booking->client->name}}</p>
                    <p>Phone: {{$loandisbursement->booking->client->phone}}</p>
                    <p>Father's Name: {{$loandisbursement->booking->client->father_name}}</p>
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
                    <p>No: {{$loandisbursement->booking->booking_no}}</p>
                    <p>Date: {{$loandisbursement->booking->booking_time}}</p>
                    <p>Total Quantity: {{$loandisbursement->booking->quantity}}</p>
                    <p>Remaining Quantity: {{$loandisbursement->booking->quantity - $loandisbursement->booking->bags_in}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <div>
                <h3>Loan Information</h3>
                <div>
                    <p>No: {{$loandisbursement->loandisbursement_no}}</p>
                    <p>Date: {{$loandisbursement->payment_date}}</p>
                    <p>Loan Amount: {{$loandisbursement->amount}}</p>
                    <p>Have To Pay: {{$loandisbursement->amount_left}}</p>
                </div>
            </div>
        </td>
    </tr>

</table>

<div style="text-align: center; color: darkblue">
    <h3>Loan Collections </h3>
</div>

<table class="bordertable">
    <thead>
    <tr>
        <th>Collection No</th>
        <th>Date</th>
        <th>Surcharge</th>
        <th>Amount</th>
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

</htmlpageheader>


<htmlpagefooter name="page-footer">


</htmlpagefooter>
</body>
</html>
