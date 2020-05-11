<?php

namespace App\Http\Controllers\Covid;

use App\GlobalData as AppGlobalData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CovidController extends Controller
{
    public function global_latest(Request $request)
    {
        $response = [];
        $date = Carbon::now()->yesterday();
        $response['deaths'] = AppGlobalData::where('date', $date->toDateString())->get()->sum('deaths');
        $response['confirmed'] = AppGlobalData::where('date', $date->toDateString())->get()->sum('confirmed');
        $response['recovered'] = AppGlobalData::where('date', $date->toDateString())->get()->sum('recovered');
        $response['active_cases'] = $response['confirmed'] - $response['recovered'] - $response['deaths'];

        return  $response;
    }

    public function country_latest(Request $request, $country)
    {
        return AppGlobalData::where('country', $country)->latest('date')->firstOrFail();
    }

    public function by_country_date(Request $request, $country, $date)
    {
        return AppGlobalData::where('country', $country)->where('date', $date)->firstOrFail();
    }

    public function country_all(Request $request, $country)
    {
        // return $country;
        return AppGlobalData::where('country', $country)->get();
    }
}
