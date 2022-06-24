<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Product;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_offers'])->only('index');
        $this->middleware(['permission:add_offers'])->only('create');
        $this->middleware(['permission:edit_offers'])->only('edit');
        $this->middleware(['permission:delete_offers'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $offers = Offer::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $offers = $offers->where('title', 'like', '%'.$sort_search.'%');
        }
        $offers = $offers->paginate(15);
        return view('backend.marketing.offers.index', compact('offers', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.marketing.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offer              = new Offer;
        $offer->title       = $request->title;

        $date_var           = explode(" to ", $request->date_range);
        $offer->start_date  = strtotime($date_var[0]);
        $offer->end_date    = strtotime( $date_var[1]);

        $offer->slug                = strtolower(str_replace(' ', '-', $request->title).'-'.Str::random(5));
        $offer->banner              = $request->banner;
        $offer->status              = 1;

        if($offer->save()){
            foreach ($request->products as $key => $product_id) {
                $offer_product              = new OfferProduct;
                $offer_product->offer_id    = $offer->id;
                $offer_product->product_id  = $product_id;
                $offer_product->save();

                $root_product                       = Product::findOrFail($product_id);
                $root_product->discount             = $request['discount_'.$product_id];
                $root_product->discount_type        = $request['discount_type_'.$product_id];
                $root_product->discount_start_date  = strtotime($date_var[0]);
                $root_product->discount_end_date    = strtotime( $date_var[1]);
                $root_product->save();
            }

            flash(translate('Flash Deal has been inserted successfully'))->success();
            return redirect()->route('offers.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
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
        $offer = Offer::findOrFail($id);
        return view('backend.marketing.offers.edit', compact('offer'));
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
        $offer = Offer::findOrFail($id);
        $offer->title = $request->title;

        $date_var               = explode(" to ", $request->date_range);
        $offer->start_date = strtotime($date_var[0]);
        $offer->end_date   = strtotime( $date_var[1]);

        if (($offer->slug == null) || ($offer->title != $request->title)) {
            $offer->slug = strtolower(str_replace(' ', '-', $request->title) . '-' . Str::random(5));
        }

        $offer->banner = $request->banner;

        $offer->offer_products()->delete();

        if($offer->save()){
            foreach ($request->products as $key => $product_id) {
                $offer_product = new OfferProduct;
                $offer_product->offer_id = $offer->id;
                $offer_product->product_id = $product_id;
                $offer_product->save();

                $root_product = Product::findOrFail($product_id);
                $root_product->discount = $request['discount_'.$product_id];
                $root_product->discount_type = $request['discount_type_'.$product_id];
                $root_product->discount_start_date = strtotime($date_var[0]);
                $root_product->discount_end_date   = strtotime( $date_var[1]);
                $root_product->save();
            }

            flash(translate('Offer has been updated successfully'))->success();
            return redirect()->route('offers.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->offer_products()->delete();
        Offer::destroy($id);
        flash(translate('Offer has been deleted successfully'))->success();
        return redirect()->route('offers.index');
    }

    public function update_status(Request $request)
    {
        $offer = Offer::findOrFail($request->id);
        $offer->status = $request->status;
        if($offer->save()){
            flash(translate('Offer status updated successfully'))->success();
            return 1;
        }
        return 0;
    }


    public function product_discount(Request $request){
        $product_ids = $request->product_ids;
        return view('backend.marketing.offers.offer_discount', compact('product_ids'));
    }

    public function product_discount_edit(Request $request){
        $product_ids = $request->product_ids;
        $offer_id = $request->offer_id;
        return view('backend.marketing.offers.offer_discount_edit', compact('product_ids', 'offer_id'));
    }
}
