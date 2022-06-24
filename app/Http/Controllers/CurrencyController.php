<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:show_currencies'])->only('index');
        $this->middleware(['permission:add_currencies'])->only('create');
        $this->middleware(['permission:edit_currencies'])->only('edit');
    }

    public function changeCurrency(Request $request)
    {
    	$request->session()->put('currency_code', $request->currency_code);
        $currency = Currency::where('code', $request->currency_code)->first();
    	flash(translate('Currency changed to ').$currency->name)->success();
    }

    public function index(Request $request)
    {
        $sort_search =null;
        $currencies = Currency::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $currencies = $currencies->where('name', 'like', '%'.$sort_search.'%');
        }
        $currencies = $currencies->paginate(10);

        $active_currencies = Currency::all();
        return view('backend.settings.currencies.index', compact('currencies', 'active_currencies','sort_search'));
    }

    public function updateYourCurrency(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $currency->status;
        if($currency->save()){
            flash(translate('Currency updated successfully'))->success();
            return redirect()->route('currency.index');
        }
        else {
            flash(translate('Something went wrong'))->error();
            return redirect()->route('currency.index');
        }
    }

    public function create()
    {
        return view('backend.settings.currencies.create');
    }

    public function edit(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        return view('backend.settings.currencies.edit', compact('currency'));
    }

    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = '0';
        if($currency->save()){
            flash(translate('Currency updated successfully'))->success();
            return redirect()->route('currency.index');
        }
        else {
            flash(translate('Something went wrong'))->error();
            return redirect()->route('currency.index');
        }
    }

    public function update_status(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->status = $request->status;
        if($currency->save()){
            return 1;
        }
        return 0;
    }
}
