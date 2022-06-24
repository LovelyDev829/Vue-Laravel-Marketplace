<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_customers'])->only('index');
        $this->middleware(['permission:view_customers'])->only('show');
        $this->middleware(['permission:delete_customers'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $customers = User::where('user_type','customer')->withCount('orders')->orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $customers = $customers->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
        }
        $customers = $customers->paginate(15);
        return view('backend.customers.index', compact('customers', 'sort_search'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.customers.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->orders()->delete();
        $user->reviews()->delete();
        $user->carts()->delete();
        $user->wallets()->delete();
        $user->addresses()->delete();
        $user->reviews()->delete();

        $user->delete();

        flash(translate('Customer deleted successfully'))->error();
        return back();
    }

    public function ban($id) {
        $user = User::find($id);

        if($user->banned == 1) {
            $user->banned = 0;
            flash(translate('Customer Unbanned Successfully'))->success();
        } else {
            $user->banned = 1;
            flash(translate('Customer Banned Successfully'))->success();
        }

        $user->save();

        return back();
    }
}
