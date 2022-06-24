<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use Illuminate\Http\Request;
use ZipArchive;
use DB;
use App\Models\Setting;
use Artisan;
use Illuminate\Support\Str;
use Storage;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.addons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.addons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        cache_clear();

        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return back();
        }

        if (class_exists('ZipArchive')) {
            if ($request->hasFile('addon_zip')) {
                // Create update directory.
                $dir = 'addons';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = Storage::disk('local')->put('addons', $request->addon_zip);

                //Unzip uploaded update file and remove zip file.
                $zip = new ZipArchive;
                $res = $zip->open(base_path('public/' . $path));

                $random_dir = Str::random(10);

                $dir = trim($zip->getNameIndex(0), '/');

                if ($res === true) {
                    $res = $zip->extractTo(base_path('temp/' . $random_dir . '/addons'));
                } else {
                    dd('could not open addon zip file');
                }

                $str = file_get_contents(base_path('temp/' . $random_dir . '/addons/' . $dir . '/config.json'));
                $json = json_decode($str, true);

                //dd($random_dir, $json);

                if (Setting::where('type', 'current_version')->first()->value >= $json['minimum_item_version']) {
                    $dir = 'app/Addons';
                    if (!is_dir($dir))
                        mkdir($dir, 0777, true);

                    $res = $zip->extractTo(base_path('app/Addons'));
                    $zip->close();

                    if (count(Addon::where('unique_identifier', $json['unique_identifier'])->get()) == 0) {
                        $addon = new Addon;
                        $addon->name = $json['name'];
                        $addon->unique_identifier = $json['unique_identifier'];
                        $addon->version = $json['version'];
                        $addon->activated = 1;
                        $addon->image = 'app/Addons/' . ucfirst(str_replace('_', '', $json['unique_identifier'])) . '/' . $json['addon_banner'];
                        $addon->purchase_code = $request->purchase_code;
                        $addon->save();

                        flash(translate('Addon installed successfully'))->success();
                        return redirect()->route('addons.index');
                    } else {
                        $addon = Addon::where('unique_identifier', $json['unique_identifier'])->first();
                        $addon->version = $json['version'];
                        $addon->purchase_code = $request->purchase_code;
                        $addon->save();

                        flash(translate('This addon is updated successfully'))->success();
                        return redirect()->route('addons.index');
                    }
                } else {
                    flash(translate('This version is not capable of installing Addons, Please update.'))->error();
                    return redirect()->route('addons.index');
                }
            }
        } else {
            flash(translate('Please enable ZipArchive extension.'))->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\Response
     */
    public function show(Addon $addon)
    {
        //
    }

    public function list()
    {
        //return view('backend.'.Auth::user()->role.'.addon.list')->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\Response
     */
    public function edit(Addon $addon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\Response
     */
    public function activation(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return 0;
        }
        $addon = Addon::find($request->id);
        $addon->activated = $request->status;
        $addon->save();

        cache_clear();

        return 1;
    }
}
