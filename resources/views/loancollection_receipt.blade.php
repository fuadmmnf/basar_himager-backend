<html>
<head>
    <title>Download Loan Collection Receipt</title>
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
    <p style="font-size: 1.4rem; font-weight: bold">Loan Collection Receipt</p>
    <p><b>Collection No:</b> {{$loancollection->loancollection_no}}</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>Client Information</h3>
                <div>
                    <p>Name: {{$loancollection->loandisbursement->booking->client->name}}</p>
                    <p>Phone: {{$loancollection->loandisbursement->booking->client->phone}}</p>
                    <p>Father's Name: {{$loancollection->loandisbursement->booking->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>

</table>

<table>
    <tr>
        <td style="width: 60%; text-align: left">
            <div   >
                <h3>Loan Disbursement Information</h3>
                <div>
                    <p>No:{{$loancollection->loandisbursement->loandisbursement_no}} </p>
                    <p>Date: {{$loancollection->loandisbursement->payment_date}}</p>
                    <p>Loan Amount: {{$loancollection->loandisbursement->amount}}</p>
                    <p>Remaining Amount: {{$loancollection->pending_loan_amount}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: left; width: 40%">
            <div   >
                <h3>Loan Collection Information</h3>
                <div>
                    <p>No:{{$loancollection->loancollection_no}} </p>
                    <p>Date: {{$loancollection->payment_date}}</p>
                    <p>Surcharge: {{$loancollection->surcharge}}</p>
                    <p>Payment Amount: {{$loancollection->payment_amount}}</p>
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
