<?php

function bangla($str)
{
    $en = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
    $bn = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
    $str = str_replace($en, $bn, $str);
    $en = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $en_short = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $bn = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    $str = str_replace($en, $bn, $str);
    $str = str_replace($en_short, $bn, $str);
    $en = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $en_short = ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
    $bn_short = ['শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহঃ', 'শুক্র'];
    $bn = ['শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার'];
    $str = str_replace($en, $bn, $str);
    $str = str_replace($en_short, $bn_short, $str);

//    $en = ['am', 'pm', 'AM', 'PM'];
//    $bn = ['পূর্বাহ্ন', 'অপরাহ্ন', 'পূর্বাহ্ন', 'অপরাহ্ন'];
//    $str = str_replace($en, $bn, $str);
    $en = ['due', 'due_paid', 'advance', 'advance_paid'];
    $bn = ['বকেয়া', 'বকেয়া ফেরত', 'অগ্রিম', 'অগ্রিম ফেরত'];
    return str_replace($en, $bn, $str);
}

function createSlug($text)
{
    $text = str_replace('!', '', $text);
    return preg_replace('/\s+/u', '-', trim($text));
}

function random_string($length)
{
    $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
}

function generate_token($length)
{
    $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
}

function random_otp($length)
{
    $pool = '0123456789';
    return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
}

function ordinal($number)
{
    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    if (($number % 100 >= 11) && ($number % 100 <= 13)) {
        return $number . 'th';
    }

    return $number . $ends[$number % 10];
}

function bangla_month_to_eng_month($str)
{
    $bn = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    $en = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    return str_replace($bn, $en, $str);
}
function display_local_time($time) {
    return $time->setTimeZone('Asia/Dhaka');
}

