<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AttributeCollection;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategorySingleCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductSingleCollection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;

class ProductController extends Controller
{
    public function index()
    {
        return new ProductCollection(Product::latest()->paginate(10));
    }

    public function show($product_slug)
    {
        $product = filter_products(Product::query())
            ->where('slug', $product_slug)
            ->with(['brand', 'variations', 'variation_combinations','shop' => function($query){
                $query->withCount('reviews');
            }])
            ->withCount(['reviews', 'reviews_1', 'reviews_2', 'reviews_3', 'reviews_4', 'reviews_5'])
            ->first();
        if ($product) {
            return new ProductSingleCollection($product);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Product not found')
            ]);
        }
    }

    public function get_by_ids(Request $request)
    {
        if ($request->has('product_ids') && is_array($request->product_ids)) {
            return new ProductCollection(filter_products(Product::whereIn('id', $request->product_ids))->get());
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Products not found')
            ], 200);
        }
    }

    public function related($product_id)
    {
        $products = filter_products(Product::query())->whereHas('product_categories', function ($query) use ($product_id) {
            $query->whereIn('category_id', Product::find($product_id)->product_categories->pluck('category_id')->toArray());
        })->where('id', '!=', $product_id)->limit(10)->get();
        return new ProductCollection($products);
    }

    public function bought_together($product_id)
    {
        $order_ids = OrderDetail::where('product_id', $product_id)->pluck('order_id')->toArray();
        $product_ids = OrderDetail::distinct()->whereIn('order_id', $order_ids)->where('product_id', '!=', $product_id)->pluck('product_id')->toArray();
        $products = filter_products(Product::whereIn('id', $product_ids))->limit(10)->get();
        return new ProductCollection($products);
    }

    public function random_products($limit, $product_id = null)
    {
        return new ProductCollection(filter_products(Product::where('id', '!=', $product_id))->inRandomOrder()->limit($limit)->get());
    }
    public function latest_products($limit)
    {
        return new ProductCollection(filter_products(Product::query())->latest()->limit($limit)->get());
    }

    public function search(Request $request)
    {
        $category                   = $request->category_slug ? Category::where('slug', $request->category_slug)->first() : null;
        $search_keyword             = $request->keyword;
        $sort_by                    = $request->sort_by;
        $category_id                = optional($category)->id;
        $brand_ids                  = $request->brand_ids ? explode(',',$request->brand_ids) : null;
        $min_price                  = $request->min_price;
        $max_price                  = $request->max_price;
        $attributes                 = Attribute::with('attribute_values')->get();
        $selected_attribute_values  = $request->attribute_values ? explode(',',$request->attribute_values) : null;

        $products = filter_products(Product::with(['variations']));

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
                    $ids = Category::where('name', 'like', '%'.$word.'%')->pluck('id')->toArray();
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
            'metaTitle' => $category ? $category->meta_title : get_setting('meta_title'),
            'products' => $collection,
            'totalPage' => $collection->lastPage(),
            'currentPage' => $collection->currentPage(),
            'total' => $collection->total(),
            'parentCategory' => $category && $category->parent_id != 0 ? new CategorySingleCollection(Category::find($category->parent_id)) : null,
            'currentCategory' => $category? new CategorySingleCollection($category) : null,
            'childCategories' => $category ? new CategoryCollection($category->childrenCategories) : null,
            'rootCategories' => new CategoryCollection(Category::where('level', 0)->orderBy('order_level', 'desc')->get()),
            'allBrands' => new BrandCollection(Brand::all()),
            'attributes' => new AttributeCollection($attributes)
        ]);
    }

}
