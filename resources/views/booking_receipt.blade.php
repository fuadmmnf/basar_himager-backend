@extends('layouts.receipt')

@section('title')
    Booking Receipt
@endsection

@section('receipt-title')
    বুকিং রশিদ
@endsection
@section('content')
<table>
    <tr>
        <td rowspan="3" style="width: 35%; text-align: left">
            <div   >
                <h3>গ্রাহকের তথ্য</h3>
                <div>
                    <p><b>নাম:</b> {{$bookinginfo->client->name}}</p>
                    <p><b>ফোন নম্বর:</b> {{$bookinginfo->client->phone}}</p>
                    <p><b>বাবার নাম</b>: {{$bookinginfo->client->father_name}}</p>
                </div>
            </div>
        </td>
        <td style="width: 30%; border: 3px solid black;  border-radius: 8px;">
            <div style="">
{{--                <b style="font-size: 1.6rem;"></b> <br />--}}

            </div>
        </td>
        <td rowspan="3" class="td-right-align" style="width: 35%; text-align: right;">
            <span align="center" style="line-height: 1.2;">
                <p><b>বুকিং নম্বর:</b> {{$bookinginfo->booking_no}}</p>
                <p><b>তারিখ:</b> {{ date('F d, Y') }}</p>
            </span>
        </td>
    </tr>
    <tr>
        <td/><td/><td/>
    </tr>
    <tr>
        <td/><td/><td/>
    </tr>
</table>

<br/>
    <table class="bordertable" style="width: 70%;margin-left: auto;margin-right: auto;">
        <tr>
            <th colspan="2"><b>বুকিং তথ্য</b></th>
        </tr>
        <tr>
            <td>বুকিং তারিখ</td>
            <td>{{ bangla(date('F d, Y', strtotime($bookinginfo->booking_time))) }}</td>
        </tr>
        <tr>
            <td>বুকিং ধরণ</td>
            <td>
                @if($bookinginfo->type == 0)
                    নরমাল
                @elseif($bookinginfo->type == 1)
                    অগ্রিম
                @endif
            </td>
        </tr>
        <tr>
            <td>বুকিং পরিমান</td>
            <td>{{$bookinginfo->quantity}} বস্তা</td>
        </tr>
        <tr>
            <td>অগ্রিম পরিশোধ</td>
            <td>
                @if($bookinginfo->advance_payment > 0)
                  {{$bookinginfo->advance_payment}} টাকা
                @else
                    0 টাকা
                @endif

{{--                    @if($bookinginfo->advance_payment > 0)--}}
{{--                        <p><b>অগ্রীম পরিশোধ:</b> {{$bookinginfo->advance_payment}}</p>--}}
{{--                    @elseif($bookinginfo->booking_amount > 0)--}}
{{--                        <p><b>বুকিং মানি:</b> {{$bookinginfo->initial_booking_amount}}</p>--}}
{{--                        <p><b>অবশিষ্ট:</b> {{$bookinginfo->booking_amount}}</p>--}}
{{--                    @endif--}}
            </td>
        </tr>

    </table>

@endsection

