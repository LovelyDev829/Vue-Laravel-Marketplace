<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferSingleCollection;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        return new OfferCollection(Offer::where('status',1)->where('start_date','<=',strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=',strtotime(date('d-m-Y H:i:s')))->get());
    }

    public function show($slug){
        $offer = Offer::with('products.variations')->where('status',1)->where('start_date','<=',strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=',strtotime(date('d-m-Y H:i:s')))->where('slug',$slug)->first();
        if($offer){
            return new OfferSingleCollection($offer);
        }else{
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => translate('Offer not found!')
            ]);
        }
    }

}
