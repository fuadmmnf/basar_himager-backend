<?php


namespace App\Repositories;


use App\Models\settings;

class SettingsRepositopry implements Interfaces\SettingsRepositoryInterface
{
    public function set(array $request){
        $setting = settings::where('key', $request['key'])->first();
        if(!$setting){
            return 'NotAvailable';
        }
        if($setting->key == 'service_charge_rate'){
            if($request['value'] < 0 || $request['value'] > 100){
                return 'Rate Must be between 0 to 100';
            }
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

    public function getSettings(){
        $settingsArr = [];
        foreach (settings::all() as $settings){
            $settingsArr[$settings->key] = $settings->value;
        }
        return $settingsArr;
    }
}
