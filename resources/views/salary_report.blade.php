<html>
<head>
    <title>Salary Report</title>
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
    <p style="font-size: 1.4rem; font-weight: bold">Salary Report</p>
    <p><b>Report No:</b> 03edkd</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>Recipient</h3>
                <div>
                    <p>House #5, Road #20, Sector #4</p>
                    <p>Uttara, Dhaka-1230</p>
                    <p>coldstorage@gmail.com</p>
                    <p>+8801234567890</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <div>
                <h3>Cold Storage</h3>
                <div>
                    <p>House #5, Road #20, Sector #4</p>
                    <p>Uttara, Dhaka-1230</p>
                    <p>coldstorage@gmail.com</p>
                    <p>+8801234567890</p>
                </div>
            </div>
        </td>
    </tr>

</table>

<table class="bordertable">
    <thead>
    <tr>
        <th>Name</th>
        <th>Designation</th>
        <th>Salary</th>
        <th>Bonus</th>
        <th>Loan Receive</th>
    </tr>

    </thead>
    <tbody>
    @if(count($salaries))
    @foreach($salaries as $salary)
        <tr>
            <td>{{$salary->employee->name}}</td>
            <td>{{$salary->employee->designation}}</td>
            <td>{{$salary->amount}}</td>
            <td>{{$salary->bonus}}</td>
            <td>{{$salary->loan_payment}}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td> <b>SUBTOTAL:</b></td>
        <td> <b>{{$salaries->sum('amount')}}</b></td>
        <td> <b>{{$salaries->sum('bonus')}}</b></td>
        <td> <b>{{$salaries->sum('loan_payment')}}</b></td>
    </tr>
    <tr>
        <td></td>
        <td> <b>TOTAL:</b></td>
        <td><b>{{$salaries->sum('amount')+ $salaries->sum('bonus') - $salaries->sum('loan_payment')}} </b></td>
        <td></td>
        <td></td>
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
