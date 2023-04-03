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
    <table>
        <tr>
            <td style="text-align: left">
                <span  style="line-height: 1.2;">
                    <p style="font-size: 1.3em"><b>রিসিপ্ট নং:</b> {{$receiptinfo->delivery_no}}</p>
                    <p><b>তারিখ:</b> {{ date('F d, Y', strtotime($receiptinfo->delivery_time)) }}</p>
                </span>

            </td>
            <td>

                <table>
                    <tr>
                        <td style="width: 50%; text-align: right">
                            <div>
                                <div>
                                    <div style="text-align: right; padding-bottom: 10px; font-size: 1.2em">
                                        <span><b>গ্রাহকের তথ্য</b></span>
                                    </div>
                                    <p><b>নাম:</b> {{$booking->client->name}}</p>
                                    <p><b>ফোন নম্বর:</b> {{$booking->client->phone}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>




    @php
        $total = 0;
    @endphp
    @if(count($receiptinfo->deliveries)>0)
        <div style="text-align: center; padding-bottom: 5px; font-size: 1.2em">
            <span><b>সংগ্রহের তথ্য</b></span>
        </div>
        <table class="bordertable">
            <thead>
            <tr>
                <th>বুকিং নম্বর</th>
                <th>এস আর/লট সংখ্যা</th>
                <th>আলু সংগ্রহ</th>
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
                            {{$item->srlot_no}} <br/>
                        @endforeach
                    </td>
                    <td>
                        @foreach($delivery->deliveryitems as $item)
                            {{$item->potato_type}} ({{$item->quantity}}) <br/>
                        @endforeach
                    </td>

                    <td>
                        <p>মোট ব্যাগ: {{$delivery->deliveryitems->sum('quantity')}}</p>
                        <p>বস্তা প্রতি খরচ: {{$delivery->cost_per_bag}}</p>
                        <p>বস্তা প্রতি ডি.ও চার্জ: {{$delivery->do_charge}}</p>
                        {{--                <p>ফ্যান খরচ: {{$delivery->quantity_bags_fanned}}({{$delivery->fancost_per_bag}})</p>--}}
                    </td>
                    <td>{{$delivery->total_charge}} ৳</td>
                    @php
                        $total += $delivery->total_charge;
                    @endphp
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif


    @if(count($receiptinfo->loancollection)>0)
        <div style="text-align: center; padding-top: 10px; padding-bottom: 5px; font-size: 1.2em">
            <span><b>লোনের তথ্য</b></span>
        </div>
        <table class="bordertable">
            <thead>
            <tr>
                <th>বুকিং নম্বর</th>
                <th>দিন</th>
                <th>সারচার্জ</th>
                <th>পরিমান</th>
                <th>মোট</th>
            </tr>

            </thead>
            <tbody>
            @foreach($receiptinfo->loancollection as $collection)
                <tr>
                    <td>{{$booking->booking_no}}</td>
                    <td>{{ round((strtotime($collection->payment_date) - strtotime($collection->loandisbursement->payment_date)) / 86400) }}</td>
                    <td>{{$collection->surcharge}}</td>
                    <td>{{$collection->payment_amount}}</td>
                    <td>{{$collection->payment_amount + $collection->surcharge}} ৳</td>
                    @php
                        $total += ($collection->payment_amount+ $collection->surcharge)
                    @endphp
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <div style="text-align: right; padding-top: 10px; font-size: 1.2em">
        <span><b>সর্বমোট:</b> {{$total}} ৳</span>
    </div>
@endsection
