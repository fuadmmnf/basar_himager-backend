<html>
<head>
    <title>Bank Deposits Report</title>
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
            border: 0;
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
    <p style="font-size: 1.4rem; font-weight: bold">Bank Deposit Report</p>
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
        <th>Bank</th>
        <th>Account No</th>
        <th>SI No</th>
        <th>Branch </th>
        <th>Amount</th>
    </tr>

    </thead>
    <tbody>
    @if(count($deposits))
    @foreach($deposits as $deposit)
        <tr>
            <td>{{$deposit->bank->name}}</td>
            <td>{{$deposit->bank->account_no}}</td>
            <td>{{$deposit->si_no}}</td>
            <td>{{$deposit->branch}}</td>
            <td>{{$deposit->amount}}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td> </td>
        <td> <b>TOTAL:</b></td>
        <td> <b>{{$deposits->sum('amount')}}</b></td>
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
