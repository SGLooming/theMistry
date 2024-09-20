<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class StateAndCityController extends Controller
{
    /**
     * @return collection of states
     * of country INDIA.
     */
    public function states()
    {
        /**
         * get the all states from the database.
         */
        $states = State::where('countryID', 'IND')->select('stateID', 'stateName')->get();

        /**
         * send the response with message.
         */
        return response([
            'success' => 'true',
            'data' => $states,
            'message' => 'All states retrived successfully.'
        ], 200);
    }
    /**
     * @return collection of cities
     * of country INDIA.
     */
    public function cities($state_id)
    {
        /**
         * get the all cities from the database.
         */
        $cities = City::where('stateID', $state_id)->select('cityID', 'cityName')->get();

        /**
         * send the response with message.
         */
        return response([
            'success' => 'true',
            'data' => $cities,
            'message' => 'All cities retrived successfully.'
        ], 200);
    }
}
