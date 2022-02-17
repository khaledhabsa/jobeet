<?php

namespace Modules\Orders\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Orders\Entities\Trip;
use Modules\Orders\Http\Requests\TripRequest;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $trips = Trip::where('company_id', auth()->user()->company_id)->get();
        return sendResponse(true, 'Trip added successfully', $trips);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TripRequest $request)
    {
        $trip = new Trip();
        $trip->company_id       = $request->user('api')->id;
        $trip->title            = $request->input('title') ;
        $trip->drop_off_address = $request->input('drop_off_address') ;
        $trip->pick_up_address  = $request->input('pick_up_address') ;
        $trip->vehicle_type     = $request->input('vehicle_type') ;
        $trip->trip_options     = $request->input('trip_options') ;
        $trip->price            = $request->input('price');
        $trip->date             = $request->input('date');
        $trip->save();

        return sendResponse(true, 'Trip added successfully', []);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
