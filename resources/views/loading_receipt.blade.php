@extends('layouts.receipt')

@section('title')
    Loading Receipt
@endsection

@section('receipt-title')
    Loading Receipt
@endsection
@section('content')
{{--<div style="text-align: center">--}}
{{--    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br />--}}
{{--    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br /> <br/>--}}

{{--    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">--}}
{{--        <b style="font-size: 1.6rem;padding: 20px">Loading Receipt</b> <br />--}}

{{--    </div>--}}

{{--</div>--}}
<span align="center" style="line-height: 1.2;">
    <p style="font-size: 1.4rem; font-weight: bold">Loading Receipt</p>
    <p><b>Report No:</b> 03edkd</p>
    <p><b>Date:</b> {{ date('F d, Y') }}</p>
</span>


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
    @if(count($salaries))
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
            <td> <b>{{$salaries->sum('basic_salary')}}</b></td>
            <td> <b>{{$salaries->sum('special_salary')}}</b></td>
            <td> <b>{{$salaries->sum('eid_bonus')}}</b></td>
        </tr>
        <tr>
            <td></td>
            <td> <b>TOTAL:</b></td>
            <td><b>{{$salaries->sum('basic_salary')+ $salaries->sum('special_salary') + $salaries->sum('eid_bonus')}} </b></td>
            <td></td>
            <td></td>
        </tr>
    @endif
    </tbody>
</table>

@endsection
