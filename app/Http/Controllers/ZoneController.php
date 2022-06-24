<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Zone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zones = Zone::paginate(15);
        return view('backend.settings.zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::where('status', 1)->where('zone_id', null)->get();
        return view('backend.settings.zones.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $zone = new Zone;
        $zone->name = $request->name;
        $zone->cities = $request->cities ? json_encode($request->cities) : '[]';
        $zone->standard_delivery_cost = $request->standard_delivery_cost ?? 0;
        $zone->express_delivery_cost = $request->express_delivery_cost ?? 0;
        $zone->save();

        foreach($request->cities as $city_id){
            $city = City::find($city_id);
            $city->zone_id = $zone->id;
            $city->save();
        }

        flash(translate('Zone has been inserted successfully'))->success();
        return redirect()->route('zones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $zone = Zone::findOrFail($id);
        $cities = City::status()->where('zone_id', null)->orWhere(function($query) use ($zone){
            return $query->where('zone_id', $zone->id);
        })->get();
        return view('backend.settings.zones.edit', compact('zone', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $zone = Zone::findOrFail($id);
        $zone->name = $request->name;
        $zone->cities = $request->cities ? json_encode($request->cities) : '[]';
        $zone->standard_delivery_cost = $request->standard_delivery_cost ?? 0;
        $zone->express_delivery_cost = $request->express_delivery_cost ?? 0;

        foreach($request->cities as $city_id){
            $city = City::find($city_id);
            $city->zone_id = $zone->id;
            $city->save();
        }

        $zone->save();

        flash(translate('Zone has been updated successfully'))->success();
        return redirect()->route('zones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);
        foreach(json_decode($zone->cities) as $city_id){
            $city = City::find($city_id);
            if($city){
                $city->zone_id = null;
                $city->save();
            }
        }
        $zone->delete();

        flash(translate('Zone has been deleted successfully'))->success();
        return redirect()->route('zones.index');
    }

    public function updateStatus(Request $request){
        $zone = Zone::findOrFail($request->id);
        $zone->status = $request->status;
        if($zone->save()){
            return 1;
        }
        return 0;
    }
}
