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
        <b style="font-size: 1.6rem;padding: 20px">Salary Report</b> <br />

    </div>

</div>
<span align="center" style="line-height: 1.2;">
    <p><b>Month:</b> {{ date('F, Y', strtotime($month)) }}</p>
</span>

<table class="bordertable">
    <thead>
    <tr>
        <th>Name</th>
        <th>Designation</th>
        <th>Basic Salary</th>
        <th>Special Salary</th>
        <th>Bonus</th>
        <th>Advance Taken</th>
        <th>Advance Returned</th>
        <th>Total Payment</th>
        <th>Payment Date</th>
    </tr>

    </thead>
    <tbody>
    @if(count($salaries))
        @foreach($salaries as $salary)
            <tr>
                <td>{{$salary->employee->name}}</td>
                <td>{{$salary->employee->designation}}</td>
                <td>{{$salary->employee->basic_salary}}</td>
                <td>{{$salary->employee->special_salary}}</td>
                <td>{{$salary->bonus}}<br><small>({{$salary->remark}})</small></td>
                <td>{{$salary->loan_taken}}</td>
                <td>{{$salary->loan_returned}}</td>
                <td>{{$salary->amount + $salary->bonus}}</td>
                <td>{{ date('F d, Y', strtotime($salary->payment_time)) }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td> <b>SUBTOTAL:</b></td>
            <td> </td>
            <td> </td>
            <td></td>
            <td>{{$salaries->sum('loan_taken')}}</td>
            <td> {{$salaries->sum('loan_returned')}}</td>
            <td> {{$salaries->sum('amount') + $salaries->sum('bonus')}}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td> <b>TOTAL<small>(Pay)</small>:</b></td>
            <td><b>{{$salaries->sum('amount')+ $salaries->sum('bonus') - $salaries->sum('loan_payment')}} </b></td>
            <td></td>
        </tr>
    @endif
    </tbody>
</table>

{{--<div class="footer">--}}
{{--    <table >--}}
{{--        <tr>--}}
{{--            <td width="50%">--}}
{{--                <div>--}}
{{--                    <hr style="width: 60%"/>--}}
{{--                    <b>Recepient</b>--}}
{{--                </div>--}}

{{--            </td>--}}
{{--            <td>--}}
{{--                <div>--}}
{{--                    <hr style="width: 60%"/>--}}
{{--                    <b>Authority</b>--}}
{{--                </div>--}}

{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}


{{--</div>--}}

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

