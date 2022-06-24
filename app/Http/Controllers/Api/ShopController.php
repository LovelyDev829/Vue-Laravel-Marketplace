<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\AttributeCollection;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategorySingleCollection;
use App\Http\Resources\CouponCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ShopCollection;
use App\Http\Resources\ShopResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\Brand;
use App\Models\User;
use App\Utility\CategoryUtility;
use Hash;
use Str;

class ShopController extends Controller
{
    public function shop_register(Request $request)
    {
        if (!$request->has('phone') || !$request->has('email')) {
            return response()->json([
                'success' => false,
                'message' => translate('Email & phone is required.'),
            ], 200);
        }
        if ($request->password != $request->confirmPassword) {
            return response()->json([
                'success' => false,
                'message' => translate("Password and confirm password didn't match"),
            ], 200);
        }

        $user = User::where('phone', $request->phone)->orWhere('email', $request->email)->first();
        if ($user != null) {
            return response()->json([
                'success' => false,
                'message' => translate('User already exists with this email or phone.'),
            ]);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->save();

        // slug increment
        $slug = Str::slug($request->shopName, '-');
        $same_slug_count = Shop::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count > 0 ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $shop = new Shop;
        $shop->user_id = $user->id;
        $shop->name = $request->shopName;
        $shop->slug = $slug;
        $shop->phone = $request->shopPhone;
        $shop->address = $request->shopAddress;
        $shop->save();

        $user->shop_id = $shop->id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => translate('Thanks for registering your shop.'),
        ]);
    }

    public function index(Request $request)
    {
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $shops = filter_shops(Shop::withCount(['products', 'reviews'])->with('categories'));

        if ($category_id) {
            $shops->whereHas('shop_categories', function ($query) use ($category_id) {
                return $query->where('category_id', $category_id);
            });
        }
        if ($brand_id) {
            $shops->whereHas('brands', function ($query) use ($category_id) {
                return $query->where('brand_id', $category_id);
            });
        }

        return new ShopCollection($shops->paginate(12));
    }

    public function show($slug, Request $request)
    {
        $shop = filter_shops(Shop::where('slug', $slug)->with(['categories'])->withCount(['reviews']))->first();

        if ($shop) {
            return response()->json([
                'success' => true,
                'data' => new ShopResource($shop),
                'message' => translate('Shop found')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Shop not found')
            ]);
        }
    }

    public function shop_home($slug, Request $request)
    {
        $shop = filter_shops(Shop::where('slug', $slug)->with([])->withCount(['reviews']))->first();

        if ($shop) {
            $featured_products =  Product::whereIn('id', json_decode($shop->featured_products ?? '[]'))->where('published', 1)->get();
            $new_arrival_products =  Product::where('shop_id', $shop->id)->where('published', 1)->latest()->limit(10)->get();
            $best_rated_products =  Product::where('shop_id', $shop->id)->where('published', 1)->orderBy('rating', 'desc')->limit(10)->get();
            $best_selling_products =  Product::where('shop_id', $shop->id)->where('published', 1)->orderBy('num_of_sale', 'desc')->limit(10)->get();
            $latest_coupons = Coupon::where('shop_id', $shop->id)->where('start_date', '<=', strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=', strtotime(date('d-m-Y H:i:s')))->limit(5)->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'featured_products' => new ProductCollection($featured_products),
                    'new_arrival_products' => new ProductCollection($new_arrival_products),
                    'best_rated_products' => new ProductCollection($best_rated_products),
                    'best_selling_products' => new ProductCollection($best_selling_products),
                    'latest_coupons' => new CouponCollection($latest_coupons),
                    'banner_section_one' => get_banners($shop->banners_1),
                    'banner_section_two' => get_banners($shop->banners_2),
                    'banner_section_three' => get_banners($shop->banners_3),
                    'banner_section_four' => get_banners($shop->banners_4),
                ],
                'message' => translate('Shop found')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Shop not found')
            ]);
        }
    }

    public function shop_coupons($slug, Request $request)
    {
        $shop = filter_shops(Shop::where('slug', $slug)->with([])->withCount(['reviews']))->first();

        if ($shop) {
            return response()->json([
                'success' => true,
                'data' => [
                    'coupons' => new CouponCollection(Coupon::where('shop_id', $shop->id)->where('start_date', '<=', strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=', strtotime(date('d-m-Y H:i:s')))->get()),
                ],
                'message' => translate('Shop found')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Shop not found')
            ]);
        }
    }

    public function shop_products($slug, Request $request)
    {
        $shop = filter_shops(Shop::where('slug', $slug))->first();
        if (!$shop) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Shop not found')
            ]);
        }

        $shop_categories = $shop->categories();

        $category                   = $request->category_slug ? Category::where('slug', $request->category_slug)->first() : null;
        $search_keyword             = $request->keyword;
        $sort_by                    = $request->sort_by;
        $category_id                = optional($category)->id;
        $brand_ids                  = $request->brand_ids ? explode(',', $request->brand_ids) : null;
        $min_price                  = $request->min_price;
        $max_price                  = $request->max_price;
        $rootCategories             = $shop_categories->where('level', 0)->orderBy('order_level', 'desc')->get();
        $attributes                 = Attribute::with('attribute_values')->whereIn('id', $shop_categories->pluck('id')->toArray())->get();
        $selected_attribute_values  = $request->attribute_values ? explode(',', $request->attribute_values) : null;

        $products = filter_products(Product::with(['variations'])->where('shop_id', $shop->id));

        //brand check
        if ($brand_ids != null) {
            $products->whereIn('brand_id', $brand_ids);
        }


        // search keyword check
        if ($search_keyword != null) {
            $products->where(function ($q) use ($search_keyword) {
                foreach (explode(' ', trim($search_keyword)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%')->orWhere('tags', 'like', '%' . $word . '%');
                }
            });
        }


        // category + child category check
        if ($category_id != null) {

            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products->with('product_categories')->whereHas('product_categories', function ($query) use ($category_ids) {
                return $query->whereIn('category_id', $category_ids);
            });

            $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
            $attributes = Attribute::with('attribute_values')->whereIn('id', $attribute_ids)->get();
        } else {
            $category_ids = [];
            if ($search_keyword != null) {
                foreach (explode(' ', trim($search_keyword)) as $word) {
                    $ids = Category::where('name', 'like', '%' . $word . '%')->pluck('id')->toArray();
                    if (count($ids) > 0) {
                        foreach ($ids as $id) {
                            $category_ids[] = $id;
                            array_merge($category_ids, CategoryUtility::children_ids($id));
                        }
                    }
                }

                $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
                $attributes = Attribute::with('attribute_values')->whereIn('id', $attribute_ids)->get();
            }
        }

        //price range
        if ($min_price != null) {
            $products->where('lowest_price', '>=', $min_price);
        }
        if ($max_price != null) {
            $products->where('highest_price', '<=', $max_price);
        }

        //filter by attribute value
        if ($selected_attribute_values) {
            $products->with('attribute_values')->whereHas('attribute_values', function ($query) use ($selected_attribute_values) {
                return $query->whereIn('attribute_value_id', $selected_attribute_values);
            });
        }


        //sorting
        switch ($sort_by) {
            case 'latest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'highest_price':
                $products->orderBy('highest_price', 'desc');
                break;
            case 'lowest_price':
                $products->orderBy('lowest_price', 'asc');
                break;
            default:
                $products->orderBy('num_of_sale', 'desc');
                break;
        }

        $collection = new ProductCollection($products->paginate(20));

        return response()->json([
            'success' => true,
            'products' => $collection,
            'totalPage' => $collection->lastPage(),
            'currentPage' => $collection->currentPage(),
            'total' => $collection->total(),
            'parentCategory' => $category && $category->parent_id != 0 ? new CategorySingleCollection(Category::find($category->parent_id)) : null,
            'currentCategory' => $category ? new CategorySingleCollection($category) : null,
            'childCategories' => $category ? new CategoryCollection($category->childrenCategories()->get()) : null,
            'rootCategories' => new CategoryCollection($rootCategories),
            'allBrands' => new BrandCollection($shop->brands),
            'attributes' => new AttributeCollection($attributes)
        ]);

        return 'hello';
    }
}
