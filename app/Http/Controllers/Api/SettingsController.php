<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Settings\CreateSettingsRequest;
use App\Models\settings;
use App\Repositories\Interfaces\SettingsRepositoryInterface;

class SettingsController extends \App\Http\Controllers\ApiController
{
    private $settingsRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepository){
        $this->settingsRepository = $settingsRepository;
    }

    public function updateSettings(CreateSettingsRequest $request){
        $setting = $this->settingsRepository->set($request->validated());
        if($setting == 'NotAvailable'){
            return response()->json($setting, 203);
        }
        return response()->json($setting, 201);
    }

    public function fetch(){
        $setting = $this->settingsRepository->getSettings();
        return response()->json($setting, 200);
    }
}
