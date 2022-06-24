<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Setting;
use Artisan;
use Cache;
use Illuminate\Http\Request;
use Str;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard(Request $request)
    {   
        $root_categories = Category::where('level', 0)->get();

        $cached_graph_data = Cache::remember('cached_graph_data', 86400, function() use ($root_categories){
            $sales_amount_string = null;
            foreach ($root_categories as $key => $category){
                $category_ids = \App\Utility\CategoryUtility::children_ids($category->id);
                $category_ids[] = $category->id;
                $sales_amount = 0;

                foreach (Category::whereIn('id', $category_ids)->get() as $category) {
                    $sales_amount += $category->sales_amount;
                }
                $sales_amount_string .= $sales_amount.',';
            }
            $item['sales_amount_string'] = $sales_amount_string;

            for($i=1; $i<=12; $i++){
                $item['sales_number_per_month'][$i] = Order::where('delivery_status', '!=', 'cancelled')->whereMonth('created_at', '=', $i)->whereYear('created_at', '=', date('Y'))->count();
                $item['sales_amount_per_month'][$i] = Order::where('delivery_status', '!=', 'cancelled')->whereMonth('created_at', '=', $i)->whereYear('created_at', '=', date('Y'))->sum('grand_total');
            }

            return $item;
        });

        return view('backend.dashboard', compact('root_categories', 'cached_graph_data'));
    }

    function clearCache(Request $request)
    {   
        cache_clear();
        Setting::where('type', 'force_cache_clear_version')->update([
            "value" => strtolower(Str::random(30))
        ]);
        flash(translate('Cache cleared successfully'))->success();
        return back();
    }
}
