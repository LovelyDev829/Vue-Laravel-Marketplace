<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Hash;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_staffs'])->only('index');
        $this->middleware(['permission:add_staffs'])->only('create');
        $this->middleware(['permission:edit_staffs'])->only('edit');
        $this->middleware(['permission:delete_staffs'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('user_type', 'staff')->latest()->paginate(10);
        return view('backend.staff.staffs.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::latest()->get();
        return view('backend.staff.staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::where('email', $request->email)->first() == null){
            $admin = User::where('user_type','admin')->first();
            $user             = new User;
            $user->name       = $request->name;
            $user->shop_id    = $admin->shop_id;
            $user->email      = $request->email;
            $user->phone      = $request->mobile;
            $user->user_type  = "staff";
            $user->password   = Hash::make($request->password);
            $user->role_id    = $request->role_id;
            $user->save();
            $user->assignRole(Role::findOrFail($request->role_id)->name);

            flash(translate('Staff has been inserted successfully'))->success();
            return redirect()->route('staffs.index');
        }

        flash(translate('Email already used'))->error();
        return back();
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
        $user = User::findOrFail(decrypt($id));
        $roles = Role::latest()->get();
        return view('backend.staff.staffs.edit', compact('user','roles'));
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
        $user             = User::findOrFail($id);
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->phone      = $request->mobile;
        $user->role_id    = $request->role_id;

        if(strlen($request->password) > 0){
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->assignRole(Role::findOrFail($request->role_id)->name);

        flash(translate('Staff has been updated successfully'))->success();
        return redirect()->route('staffs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        flash(translate('Staff has been deleted successfully'))->success();
        return redirect()->route('staffs.index');
    }
}
