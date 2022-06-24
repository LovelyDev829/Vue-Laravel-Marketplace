<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Hash;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\User;
use CoreComponentRepository;
use Str;

class InstallController extends Controller
{
    public function step0() {
        $this->writeEnvironmentFile('APP_URL', URL::to('/'));
        return view('installation.step0');
    }

    public function step1() {

        $permission['curl_enabled']           = function_exists('curl_version');
        $permission['db_file_write_perm']     = is_writable(base_path('.env'));
        $permission['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
        return view('installation.step1', compact('permission'));
    }

    public function step2() {
        return view('installation.step2');
    }

    public function step3($error = "") {
        CoreComponentRepository::instantiateShopRepository();
        if($error == ""){
            return view('installation.step3');
        }else {
            return view('installation.step3', compact('error'));
        }
    }

    public function step4() {
        return view('installation.step4');
    }

    public function step5() {
        return view('installation.step5');
    }

    public function purchase_code(Request $request) {
        return redirect('step3');
    }

    public function system_settings(Request $request) {
        $setting = Setting::where('type', 'system_default_currency')->first();
        $setting->value = $request->system_default_currency;
        $setting->save();

        $this->writeEnvironmentFile('APP_NAME', $request->system_name);

        $user = User::where('user_type', 'admin')->first();
        $user->name      = $request->admin_name;
        $user->email     = $request->admin_email;
        $user->password  = Hash::make($request->admin_password);
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->save();

        $admin_shop = new Shop();
        $admin_shop->user_id = $user->id;
        $admin_shop->name = 'Inhouse Shop';
        $admin_shop->slug = Str::slug($admin_shop->name, '-');
        $admin_shop->approval = 1;
        $admin_shop->published = 1;
        $admin_shop->save();

        $user->shop_id = $admin_shop->id;
        $user->save();
        
        (new DemoController)->insert_trasnalation_keys();

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        //sleep(5);
        return view('installation.step6');

        // return redirect('step6');
    }
    public function database_installation(Request $request) {

        if($this->check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {
            $path = base_path('.env');
            if (file_exists($path)) {
                foreach ($request->types as $type) {
                    $this->writeEnvironmentFile($type, $request[$type]);
                }
                return redirect('step4');
            }else {
                return redirect('step3');
            }
        }else {
            return redirect('step3/database_error');
        }
    }

    public function import_sql() {
        $sql_path = base_path('shop.sql');
        DB::unprepared(file_get_contents($sql_path));
        return redirect('step5');
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "") {

        if(@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        }else {
            return false;
        }
    }

    public function writeEnvironmentFile($type, $val) {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            file_put_contents($path, str_replace(
                $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
            ));
        }
    }
}
