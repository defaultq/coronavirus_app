<?php

namespace App\Http\Controllers\Covid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GlobalData;
use Illuminate\Support\Carbon;

class FetchCovidController extends Controller
{
    protected function fetch_data($url)
    {

        $ch = curl_init();

        curl_setopt(
            $ch,
            CURLOPT_URL,
            $url
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close($ch);

        $csv = array_map('str_getcsv', explode("\n", $output));

        $head = $csv[0];
        unset($csv[0]);
        $data = array();
        foreach ($csv as $c) {
            if (count($head) != count($c)) continue;
            $data[]  = array_combine($head, $c);
        }

        return $data;
    }


    public function __invoke()
    {


        $data_confirmed = $this->fetch_data('https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_covid19_confirmed_global.csv');
        $data_deaths = $this->fetch_data('https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_covid19_deaths_global.csv');
        $data_recovered = $this->fetch_data('https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_time_series/time_series_covid19_recovered_global.csv');

        $all_data = [];
        $all_data['confirmed'] = $data_confirmed;
        $all_data['deaths'] = $data_deaths;
        $all_data['recovered'] = $data_recovered;

        $merged_data = [];
        foreach ($all_data as $k => $data) {
            $sort_data = [];
            $finished_data = [];

            foreach ($data as $d) {

                $test = [];

                foreach ($d as $key => $e) {

                    if (strtotime($key)) {

                        $test[$key] = $e;
                        unset($d[$key]);
                    }
                }
                foreach ($test as $key => $t) {

                    $new_arr = [];
                    $new_arr[$k] = $t;
                    $new_arr['date'] = $key;

                    array_push($sort_data, array_merge($new_arr, $d));
                }
            }

            if (empty($merged_data)) {
                $merged_data = $sort_data;
            } else {
                //  if ($k === 'recovered') {
                //     dd(array_merge($merged_data[0],$sort_data[0]));
                // }
                foreach ($merged_data as $i => $md) {
                    if (isset($sort_data[$i]) && isset($merged_data[$i])) {

                        array_push($finished_data, array_merge($merged_data[$i], $sort_data[$i]));
                    }
                }
                $merged_data = $finished_data;
            }
        }
        foreach ($finished_data as $f) {
            $data = [
                'deaths' => $f['deaths'],
                'confirmed' => $f['confirmed'],
                'recovered' => $f['recovered']

            ];
            $existing_data  = [
                'date' => Carbon::createFromFormat('m/d/y', $f['date'])->toDateTimeString(),
                'country' => $f['Country/Region'],
                'province' => $f['Province/State'],
                'latitude' => $f['Lat'],
                'longitude' => $f['Long'],
            ];
            $store = new GlobalData();

            $store->updateOrCreate($existing_data, $data);
        }
    }
}
