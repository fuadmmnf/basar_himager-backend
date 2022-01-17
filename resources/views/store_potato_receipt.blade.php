@extends('layouts.receipt')

@section('title')
    Potato Store Receipt
@endsection


@section('receipt-title')
    আলু সংরক্ষণের দলিল
@endsection
@section('content')
{{--<div style="text-align: center">--}}
{{--    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br />--}}
{{--    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br /> <br/>--}}

{{--    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">--}}
{{--        <b style="font-size: 1.6rem;padding: 20px">আলু সংরক্ষণের দলিল</b> <br />--}}

{{--    </div>--}}

{{--</div>--}}
<span align="center" style="line-height: 1.2;">
    <p style="font-size: 1.4rem; font-weight: bold">আলু সংরক্ষণের দলিল</p>
    <p><b>তারিখ: </b>{{ date('F d, Y') }}</p>
</span>
<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div   >
                <h3>গ্রাহকের তথ্য</h3>
                <br/>
                <div>
                    <p><b>গ্রাহকের নং:</b> {{$client->client_no}}</p>
                    <p><b>এন.আই.ডি:</b> {{$client->nid}}</p>
                    <p><b>নাম:</b> {{$client->name}}</p>
                    <p><b>ফোন নম্বর:</b> {{$client->phone}}</p>
                    <p><b>বাবার নাম:</b> {{$client->father_name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
        </td>
    </tr>
</table>
<br/>
<table class="bordertable">
        <thead>
            <tr>
                <th>বুকিং নম্বর</th>
                <th>বুকিং পরিমাণ</th>
                <th>রিসিভ নম্বর</th>
                <th>SR/লট নং</th>
                <th>আলুর ধরন</th>
                <th width="30%">ইনভেন্টরি</th>
            </tr>
            </thead>
        <tbody>
                @foreach($client->bookings as $booking)
                    @foreach($booking->receives as $receive)
                        @foreach($receive->receiveitems as $receiveitem)
                                @foreach($receive->loaddistributions as $load)
                                    @if($receiveitem->potato_type == $load->potato_type)
                                        <tr>
                                            <td>{{$booking->booking_no}}</td>
                                            <td>{{$booking->quantity}}</td>
                                            <td>{{$receive->receivegroup->receiving_no}}</td>
                                            <td>{{$receive->lot_no}}</td>
                                            <td>{{$receiveitem->potato_type}} ({{$receiveitem->quantity}})</td>
                                            <td>
                                                <b>Chamber: </b>{{$load->inventory->parent_info->parent_info->name}}<br/>
                                                <b>Floor: </b>{{$load->inventory->parent_info->name}}<br/>
                                                <b>Compartment: </b>{{$load->inventory->name}}<br/>
                                                (পরিমাণ: {{$load->quantity}})
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
</table>
@endsection
