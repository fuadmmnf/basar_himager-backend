@extends('layouts.receipt')

@section('title')
    Delivery Order (DO)
@endsection

@section('receipt-title')
    ডেলিভারি অর্ডার (DO)
@endsection
@section('content')
{{--<div style="text-align: center">--}}
{{--    <b style="font-size: 2.2rem">Basar Himager Limited</b> <br/>--}}
{{--    <span style="font-size: 1.2rem">Chanpara, Bhabaniganj, Bagmara, Rajshahi</span> <br/> <br/>--}}

{{--    <div style=" border: 3px solid black; width: 45%; border-radius: 8px; margin: auto">--}}
{{--        <b style="font-size: 1.6rem;padding: 20px">ডেলিভারি অর্ডার (DO)</b> <br/>--}}

{{--    </div>--}}

{{--</div>--}}
<span align="center" style="line-height: 1.2;">
    <p><b>রিসিপ্ট নং:</b> {{$receiptinfo->delivery_no}}</p>
    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($receiptinfo->delivery_time)) }}</p>
</span>


<div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>গ্রাহকের তথ্য</b></span>
</div>

<table>
    <tr>
        <td style="width: 50%; text-align: left">
            <div>
                <div>
                    <p><b>নাম:</b> {{$receiptinfo->deliveries[0]->booking->client->name}}</p>
                </div>
            </div>
        </td>
        <td class="td-right-align" style="text-align: right; width: 50%">
            <p><b>ফোন নম্বর:</b> {{$receiptinfo->deliveries[0]->booking->client->phone}}</p>
        </td>
    </tr>

</table>


<div style="text-align: center; padding-bottom: 10px; font-size: 1.2em">
    <span><b>সংগ্রহের তথ্য</b></span>
</div>
<table class="bordertable">
    <thead>
    <tr>
        <th>বুকিং নম্বর</th>
        <th>আলুর ধরন</th>
        <th>এস আর/লট সংখ্যা</th>
        <th>চার্জ</th>
        <th>মোট</th>
    </tr>

    </thead>
    <tbody>
    @foreach($receiptinfo->deliveries as $delivery)
        <tr>
            <td>{{$delivery->booking->booking_no}}</td>
            <td>
                @foreach($delivery->deliveryitems as $item)
                    {{$item->potato_type}} ({{$item->quantity}}) <br />
                @endforeach
            </td>
            <td>
                @foreach($delivery->deliveryitems as $item)
                    {{$item->srlot_no}} <br />
                @endforeach
            </td>
            <td>
                <p>মোট ব্যাগ: {{($delivery->quantity_bags_fanned * $delivery->fancost_per_bag)/($delivery->cost_per_bag + $delivery->do_charge)}}</p>
                <p>বস্তা প্রতি খরচ: {{$delivery->cost_per_bag}}</p>
                <p>ডি.ও চার্জ: {{$delivery->do_charge}}</p>
                <p>ফ্যান খরচ: {{$delivery->quantity_bags_fanned}}({{$delivery->fancost_per_bag}})</p>
            </td>
            <td>{{$delivery->total_charge}} ৳</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
