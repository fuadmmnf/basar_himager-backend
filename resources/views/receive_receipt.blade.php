@extends('layouts.receipt')

@section('title')
    Receive Receipt
@endsection

@section('receipt-title')
    আলু গ্রহণের রশিদ
@endsection
@section('content')
{{--<div style="text-align: center">--}}
{{--    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br />--}}
{{--    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br /> <br/>--}}

{{--    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">--}}
{{--        <b style="font-size: 1.6rem;padding: 20px">আলু গ্রহণের রশিদ</b> <br />--}}

{{--    </div>--}}

{{--</div>--}}


<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <span style="text-decoration: underline; font-size: 1.4rem">বুকিং তথ্য</span> <br/> <br/>
            <span>নামঃ {{$receiptinfo->receives[0]->booking->client->name}}</span> <br/>
            <span>ফোন নম্বরঃ {{$receiptinfo->receives[0]->booking->client->phone}}</span> <br/>
            <span>গ্রামঃ {{$receiptinfo->receives[0]->booking->client->address['village']}}</span>
{{--            <div>--}}
{{--                <div>--}}
{{--                    <p><b>নাম:</b> {{$receiptinfo->receives[0]->booking->client->name}}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <span style="text-decoration: underline; font-size: 1.4rem">গ্রহণের তথ্য</span> <br/> <br/>
            <span>রিসিভ নম্বরঃ {{$receiptinfo->receiving_no}}</span> <br/>
            <span>তারিখঃ {{ bangla(date('F d, Y', strtotime($receiptinfo->receiving_time))) }}</span> <br/>
            <span>নামঃ {{$receiptinfo->receives[0]->farmer_info['name']}}</span> <br/>
            <span>গ্রামঃ  {{$receiptinfo->receives[0]->farmer_info['village']}}</span>
{{--            <p><b>ফোন নম্বর:</b> {{$receiptinfo->receives[0]->booking->client->phone}}</p>--}}
        </td>
    </tr>

</table>


<table class="bordertable">
    <thead>
    <tr>
        <th>বুকিং নং</th>
        <th>বুকিং পরিমাণ</th>
        <th>SR/লট নং</th>
{{--        <th>পরিবহন</th>--}}
        <th>আলুর ধরন</th>
    </tr>

    </thead>
    <tbody>
    @foreach($receiptinfo->receives as $receive)
        <tr>
            <td>{{$receive->booking->booking_no}}</td>
            <td>{{$receive->booking_currently_left}}</td>
            <td>{{$receive->lot_no}}</td>
{{--            <td>{{ucfirst($receive->transport['type'])}} ({{$receive->transport['number']}})</td>--}}
            <td>
                @foreach($receive->receiveitems as $item)
                    {{$item->potato_type}} ({{$item->quantity}}) <br />
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>



@endsection
