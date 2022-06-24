<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_taxes'])->only('index');
        $this->middleware(['permission:add_taxes'])->only('store');
        $this->middleware(['permission:edit_taxes'])->only('edit', 'update');
        $this->middleware(['permission:delete_taxes'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $sort_search =null;
      $taxes = Tax::orderBy('created_at', 'desc');
      if ($request->has('search')){
          $sort_search = $request->search;
          $taxes = $taxes->where('name', 'like', '%'.$sort_search.'%');
      }
      $taxes = $taxes->paginate(15);
      return view('backend.settings.taxes.index', compact('taxes', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $tax            = new Tax;
      $tax->name      = $request->name;
      $tax->save();

      flash(translate('New Tax info has been added successfully'))->success();
      return redirect()->route('taxes.index');
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
      $tax = Tax::findOrFail($id);
      return view('backend.settings.taxes.edit', compact('tax'));
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
      $tax            = Tax::findOrFail($id);
      $tax->name      = $request->name;
      $tax->save();

      flash(translate('Tax info has been updated successfully'))->success();
      return redirect()->route('taxes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Tax::destroy($id);
      flash(translate('Tax Info has been deleted successfully'))->success();
      return redirect()->route('taxes.index');
    }

    public function updateStatus(Request $request)
    {
        $tax          = Tax::findOrFail($request->id);
        $tax->status  = $request->status;
        if($tax->save()){
            return 1;
        }
        return 0;
    }
}
