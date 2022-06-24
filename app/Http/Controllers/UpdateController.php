<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CombinedOrder;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;
use DB;
use Artisan;
use App\Models\Upload;
use App\Models\User;
use App\Utility\CategoryUtility;
use Illuminate\Support\Str;
use ZipArchive;

class UpdateController extends Controller
{
    public function step0(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return back();
        }
        cache_clear();
        if ($request->has('update_zip')) {
            if (class_exists('ZipArchive')) {
                // Create update directory.
                $dir = 'updates';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $dir = 'app/Addons';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = Upload::findOrFail($request->update_zip)->file_name;

                //Unzip uploaded update file and remove zip file.
                $zip = new ZipArchive;
                $res = $zip->open(base_path('public/' . $path));

                if ($res === true) {
                    $res = $zip->extractTo(base_path());
                    $zip->close();
                } else {
                    flash(translate('Could not open the updates zip file.'))->error();
                    return back();
                }

                return redirect()->route('update.step1');
            } else {
                flash(translate('Please enable ZipArchive extension.'))->error();
            }
        } else {
            return view('update.step0');
        }
    }

    public function step1()
    {
        if (get_setting('current_version') == '1.3') {

            $sql_path = base_path('sqlupdates/v14.sql');
            DB::unprepared(file_get_contents($sql_path));
            
            return redirect()->route('update.step2');
        }
        elseif (get_setting('current_version') == '1.2') {

            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif (get_setting('current_version') == '1.1') {

            $sql_path = base_path('sqlupdates/v12.sql');
            DB::unprepared(file_get_contents($sql_path));
            $this->convertForRefund();

            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif (get_setting('current_version') == '1.0.1') {

            $sql_path = base_path('sqlupdates/v11.sql');
            DB::unprepared(file_get_contents($sql_path));
            $this->convertForMultivendor();

            $sql_path = base_path('sqlupdates/v12.sql');
            DB::unprepared(file_get_contents($sql_path));
            $this->convertForRefund();
            
            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif (get_setting('current_version') == '1.0') {

            $sql_path = base_path('sqlupdates/v101.sql');
            DB::unprepared(file_get_contents($sql_path));
            
            $sql_path = base_path('sqlupdates/v11.sql');
            DB::unprepared(file_get_contents($sql_path));
            $this->convertForMultivendor();

            $sql_path = base_path('sqlupdates/v12.sql');
            DB::unprepared(file_get_contents($sql_path));
            $this->convertForRefund();
            
            $sql_path = base_path('sqlupdates/v13.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        else {
            cache_clear();
            $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
            $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
            copy($newRouteServiceProvier, $previousRouteServiceProvier);

            return view('update.done');
        }
    }

    public function step2()
    {
        cache_clear();
        Artisan::call('permission:cache-reset');

        (new DemoController)->insert_trasnalation_keys();

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }

    public function convertForMultivendor()
    {
        //create shop for amdin
        $admin = User::where('user_type', 'admin')->first();
        $admin_shop = $admin->shop;

        if (!$admin_shop) {
            $admin_shop = new Shop();
            $admin_shop->user_id = $admin->id;
            $admin_shop->name = config('app.name') ?? 'Inhouse Shop';
            $admin_shop->slug = Str::slug($admin_shop->name, '-');
            $admin_shop->approval = 1;
            $admin_shop->published = 1;
            $admin_shop->save();
        }

        // insert shop_id to admin, staff
        foreach (User::where('user_type', 'admin')->orWhere('user_type', 'staff')->get() as $user) {
            $user->shop_id = $admin_shop->id;
            $user->save();
        }

        // insert shop_id to products
        foreach (Product::where('shop_id', null)->get() as $product) {
            $product->shop_id = $admin_shop->id;
            $product->save();
        }

        // insert shop_id to reviews
        foreach (Review::where('shop_id', null)->get() as $review) {
            $review->shop_id = $admin_shop->id;
            $review->save();
        }
        $admin_shop->rating = $admin_shop->reviews()->avg('rating');
        $admin_shop->save();

        // insert shop_id to coupons
        foreach (Coupon::where('shop_id', null)->get() as $coupon) {
            $coupon->shop_id = $admin_shop->id;
            $coupon->save();
        }

        // insert shop_id to order & create combined order
        foreach (Order::where('shop_id', null)->get() as $order) {

            $combined_order = new CombinedOrder();
            $combined_order->user_id = $order->user_id;
            $combined_order->code = $order->code;
            $combined_order->shipping_address = $order->shipping_address;
            $combined_order->billing_address = $order->billing_address;
            $combined_order->grand_total = $order->grand_total;
            $combined_order->save();

            $order->shop_id = $admin_shop->id;
            $order->combined_order_id = $combined_order->id;
            $order->code = 1;
            $order->save();
        }

        //create relation with admin shop with product category level 0
        $shop_category_ids = [];
        foreach ($admin_shop->products as $product) {
            foreach ($product->product_categories as $product_category) {
                $shop_category_ids[] = CategoryUtility::get_grand_parent_id($product_category->category_id);
            }
        }
        $admin_shop->categories()->sync(array_filter($shop_category_ids));


        // create relation with admin shop with product brand
        $brand_ids = $admin_shop->products->pluck('brand_id')->toArray();
        $admin_shop->brands()->sync(array_filter($brand_ids));
    }

    public function convertForRefund(){
        // add admin, seller, percentage add in orders table

        $admin = User::where('user_type', 'admin')->first();
        $orders = Order::with('orderDetails')->where('shop_id','!=', $admin->shop_id)->get();
        foreach ($orders as $order) {
            $commission_history = $order->commission_histories()->orderBy('created_at', 'DESC')->first();

            if($commission_history){
                $order_price = $order->grand_total - $order->shipping_cost - $order->orderDetails->sum(function ($t) {
                    return $t->tax * $t->quantity;
                });

                $order->admin_commission = $commission_history->admin_commission;
                $order->seller_earning = $commission_history->seller_earning;
                $order->commission_percentage = ($commission_history->admin_commission * 100)/$order_price;
                $order->save();
            }
        }
    }
}
