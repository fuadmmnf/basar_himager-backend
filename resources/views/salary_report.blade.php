{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--    <head>--}}
{{--        <meta charset="utf-8">--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1">--}}

{{--        <title>Salary Report</title>--}}
{{--        <style>--}}
{{--            /*#tabl{*/--}}
{{--            /*    width: 100%;*/--}}
{{--            /*}*/--}}
{{--            /*#tabl td, th{*/--}}
{{--            /*    padding: 8px;*/--}}
{{--            /*    text-align: center;*/--}}
{{--            /*}*/--}}
{{--            /*.td-right-align{*/--}}
{{--            /*    text-align: right;*/--}}
{{--            /*}*/--}}

{{--        </style>--}}

{{--    </head>--}}
{{--    <body style="padding-top: 20px" >--}}
{{--    <div align="right" style="padding-right: 30px">--}}
{{--        <h3>Salary Report</h3>--}}
{{--        <div>--}}
{{--            <p><b>Report No</b></p>--}}
{{--            <span>0kqs1</span>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <p><b>Date</b></p>--}}
{{--                <?php--}}
{{--                    echo date("d/m/Y");--}}
{{--                ?>--}}
{{--            {{}}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <table>--}}
{{--        <tr>--}}
{{--            <td style="width: 50%">--}}
{{--                <div   >--}}
{{--                    <h3>Recipient</h3>--}}
{{--                    <div>--}}
{{--                        <p>House #5, Road #20, Sector #4</p>--}}
{{--                        <p>Uttara, Dhaka-1230</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p>coldstorage@gmail.com</p>--}}
{{--                        <p>+8801234567890</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </td>--}}
{{--            <td class="td-right-align" style="float: right; width: 50%">--}}
{{--                <div>--}}
{{--                    <h3>Cold Storage</h3>--}}
{{--                    <div>--}}
{{--                        <p>House #5, Road #20, Sector #4</p>--}}
{{--                        <p>Uttara, Dhaka-1230</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p>coldstorage@gmail.com</p>--}}
{{--                        <p>+8801234567890</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </td>--}}
{{--        </tr>--}}

{{--    </table>--}}

{{--    <table  >--}}
{{--        <thead>--}}
{{--            <th>Name</th>--}}
{{--            <th>Designation</th>--}}
{{--            <th>Basic Salary</th>--}}
{{--            <th>Special Salary </th>--}}
{{--            <th>Eid Bonus</th>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($salaries as $salary)--}}
{{--            <tr>--}}
{{--                <td>{{$salary->employee->name}}</td>--}}
{{--                <td>{{$salary->employee->designation}}</td>--}}
{{--                <td>{{$salary->basic_salary}}</td>--}}
{{--                <td>{{$salary->special_salary}}</td>--}}
{{--                <td>{{$salary->eid_bonus}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--            <td> <b>SUBTOTAL:</b></td>--}}
{{--            <td> <b>{{$salary->sum('basic_salary')}}</b></td>--}}
{{--            <td> <b>{{$salary->sum('special_salary')}}</b></td>--}}
{{--            <td> <b>{{$salary->sum('eid_bonus')}}</b></td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--            <td> <b>TOTAL:</b></td>--}}
{{--            <td><b>{{$salary->sum('basic_salary')+ $salary->sum('special_salary') + $salary->sum('eid_bonus')}} </b></td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    </body>--}}
{{--</html>--}}

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
        <th>Basic Salary</th>
        <th>Special Salary </th>
        <th>Eid Bonus</th>
    </tr>

    </thead>
    <tbody>
    @foreach($salaries as $salary)
        <tr>
            <td>{{$salary->employee->name}}</td>
            <td>{{$salary->employee->designation}}</td>
            <td>{{$salary->basic_salary}}</td>
            <td>{{$salary->special_salary}}</td>
            <td>{{$salary->eid_bonus}}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td> <b>SUBTOTAL:</b></td>
        <td> <b>{{$salary->sum('basic_salary')}}</b></td>
        <td> <b>{{$salary->sum('special_salary')}}</b></td>
        <td> <b>{{$salary->sum('eid_bonus')}}</b></td>
    </tr>
    <tr>
        <td></td>
        <td> <b>TOTAL:</b></td>
        <td><b>{{$salary->sum('basic_salary')+ $salary->sum('special_salary') + $salary->sum('eid_bonus')}} </b></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>


<htmlpageheader name="page-header">

</htmlpageheader>


<htmlpagefooter name="page-footer">


</htmlpagefooter>
</body>
</html>
