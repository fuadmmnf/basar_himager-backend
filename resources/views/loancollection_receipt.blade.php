@extends('layouts.receipt')

@section('title')
    Loan Collection Receipt
@endsection

@section('receipt-title')
    লোন পরিশোধের রশিদ
@endsection
@section('content')

{{--<div style="text-align: center">--}}
{{--    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br />--}}
{{--    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br /> <br/>--}}

{{--    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">--}}
{{--        <b style="font-size: 1.6rem;padding: 20px">লোন পরিশোধের রশিদ</b> <br />--}}

{{--    </div>--}}

{{--</div>--}}
<span align="center" style="line-height: 1.2;">
    <p style="font-size: 1.4rem; font-weight: bold">লোন পরিশোধের রশিদ</p>
    <p><b>সংগ্রহের নং:</b> {{$loancollection->loancollection_no}}</p>
    <p><b>তারিখ:</b> {{ date('F d, Y') }}</p>
</span>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>গ্রাহকের তথ্য</h3>
                <div>
                    <p><b>নাম:</b> {{$loancollection->loandisbursement->booking->client->name}}</p>
                    <p><b>ফোন নম্বর:</b> {{$loancollection->loandisbursement->booking->client->phone}}</p>
                    <p><b>বাবার নাম:</b> {{$loancollection->loandisbursement->booking->client->father_name}}</p>
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
                <h3>লোন বিতরণের তথ্য</h3>
                <br>
                <div>
                    <p><b>লোন বিতরণের নং:</b> {{$loancollection->loandisbursement->loandisbursement_no}} </p>
                    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($loancollection->loandisbursement->payment_date)) }}</p>
                    <p><b>লোনের পরিমান:</b> {{$loancollection->loandisbursement->amount}}</p>
                    <p><b>অবশিষ্ট:</b> {{$loancollection->pending_loan_amount}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: left; width: 40%">
            <div   >
                <h3>লোন পরিশোধের তথ্য</h3>
                <br>
                <div>
                    <p><b>ডি ও নং:</b> {{$loancollection->deliverygroup->delivery_no}} </p>
                    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($loancollection->payment_date)) }}</p>
                    <p><b>সারচার্জ:</b> {{$loancollection->surcharge}}</p>
                    <p><b>পরিশোধ:</b> {{$loancollection->payment_amount}}</p>
                </div>
            </div>

        </td>
    </tr>

</table>

@endsection
