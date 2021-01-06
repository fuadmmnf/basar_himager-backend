<?php


namespace App\Repositories;


use App\Models\settings;

class SettingsRepositopry implements Interfaces\SettingsRepositoryInterface
{
    public function set(array $request){
        $setting = settings::where('key',$request['key'])->first();
        if(!$setting){
            return 'NotAvailable';
        }
        $setting->value = $request['value'];
        $setting->save();
        return $setting;
    }

    public function get($key){
        $setting = settings::where('key', $key)->first();
        if(!$setting){
            return 'NotAvailable';
        }
        return $setting;

    }
}
