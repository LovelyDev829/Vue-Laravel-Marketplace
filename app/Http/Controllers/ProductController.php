<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTranslation;
use App\Models\ProductVariation;
use App\Models\ProductVariationCombination;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductTax;
use App\Models\ShopBrand;
use App\Models\User;
use App\Utility\CategoryUtility;
use Artisan;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_products'])->only('index');
        $this->middleware(['permission:add_products'])->only('create');
        $this->middleware(['permission:view_products'])->only('show');
        $this->middleware(['permission:edit_products'])->only('edit');
        $this->middleware(['permission:duplicate_products'])->only('duplicate');
        $this->middleware(['permission:delete_products'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        $products = Product::orderBy('created_at', 'desc')->where('shop_id', auth()->user()->shop_id);
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->paginate(15);
        $type = 'All';

        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('level', 0)->get();
        $attributes = Attribute::get();
        return view('backend.product.products.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        CoreComponentRepository::instantiateShopRepository();
        if ($request->has('is_variant') && !$request->has('variations')) {
            flash(translate('Invalid product variations'))->error();
            return redirect()->back();
        }

        $product                    = new Product;
        $product->name              = $request->name;
        $product->shop_id           = auth()->user()->shop_id;
        $product->brand_id          = $request->brand_id;
        $product->unit              = $request->unit;
        $product->min_qty           = $request->min_qty;
        $product->max_qty           = $request->max_qty;
        $product->photos            = $request->photos;
        $product->thumbnail_img     = $request->thumbnail_img;
        $product->description       = $request->description;
        $product->published         = $request->status;

        // SEO meta
        $product->meta_title        = (!is_null($request->meta_title)) ? $request->meta_title : $product->name;
        $product->meta_description  = (!is_null($request->meta_description)) ? $request->meta_description : strip_tags($product->description);
        $product->meta_image          = (!is_null($request->meta_image)) ? $request->meta_image : $product->thumbnail_img;
        $product->slug              = Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));

        // warranty
        $product->has_warranty      = $request->has('has_warranty') && $request->has_warranty == 'on' ? 1 : 0;

        // tag
        $tags                       = array();
        if ($request->tags != null) {
            foreach (json_decode($request->tags) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags              = implode(',', $tags);

        // lowest highest price
        if ($request->has('is_variant') && $request->has('variations')) {
            $product->lowest_price  =  min(array_column($request->variations, 'price'));
            $product->highest_price =  max(array_column($request->variations, 'price'));
        } else {
            $product->lowest_price  =  $request->price;
            $product->highest_price =  $request->price;
        }

        // stock based on all variations
        $product->stock             = ($request->has('is_variant') && $request->has('variations')) ? max(array_column($request->variations, 'stock')) : $request->stock;

        // discount
        $product->discount          = $request->discount;
        $product->discount_type     = $request->discount_type;
        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime($date_var[1]);
        }

        // shipping info
        $product->standard_delivery_time    = $request->standard_delivery_time;
        $product->express_delivery_time     = $request->express_delivery_time;
        $product->weight                    = $request->weight;
        $product->height                    = $request->height;
        $product->length                    = $request->length;
        $product->width                     = $request->width;

        $product->save();

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->unit = $request->unit;
        $product_translation->description = $request->description;
        $product_translation->save();

        // category
        $product->categories()->sync($request->category_ids);

        // shop category ids
        $shop_category_ids = [];
        foreach ($request->category_ids ?? [] as $id) {
            $shop_category_ids[] = CategoryUtility::get_grand_parent_id($id);
        }
        $shop_category_ids =  array_merge(array_filter($shop_category_ids), $product->shop->shop_categories->pluck('category_id')->toArray());
        $product->shop->categories()->sync($shop_category_ids);

        // shop brand
        if ($request->brand_id) {
            ShopBrand::updateOrCreate([
                'shop_id' => $product->shop_id,
                'brand_id' => $request->brand_id,
            ]);
        }


        //taxes
        $tax_data = array();
        $tax_ids = array();
        if ($request->has('taxes')) {
            foreach ($request->taxes as $key => $tax) {
                array_push($tax_data, [
                    'tax' => $tax,
                    'tax_type' => $request->tax_types[$key]
                ]);
            }
            $tax_ids = $request->tax_ids;
        }
        $taxes = array_combine($tax_ids, $tax_data);

        $product->product_taxes()->sync($taxes);


        //product variation
        $product->is_variant        = ($request->has('is_variant') && $request->has('variations')) ? 1 : 0;

        if ($request->has('is_variant') && $request->has('variations')) {
            foreach ($request->variations as $variation) {
                $p_variation              = new ProductVariation;
                $p_variation->product_id  = $product->id;
                $p_variation->code        = $variation['code'];
                $p_variation->price       = $variation['price'];
                $p_variation->stock       = $variation['stock'];
                $p_variation->sku         = $variation['sku'];
                $p_variation->img         = $variation['img'];
                $p_variation->save();

                foreach (array_filter(explode("/", $variation['code'])) as $combination) {
                    $p_variation_comb                         = new ProductVariationCombination;
                    $p_variation_comb->product_id             = $product->id;
                    $p_variation_comb->product_variation_id   = $p_variation->id;
                    $p_variation_comb->attribute_id           = explode(":", $combination)[0];
                    $p_variation_comb->attribute_value_id     = explode(":", $combination)[1];
                    $p_variation_comb->save();
                }
            }
        } else {
            $variation              = new ProductVariation;
            $variation->product_id  = $product->id;
            $variation->sku         = $request->sku;
            $variation->price       = $request->price;
            $variation->stock       = $request->stock;
            $variation->save();
        }

        // attribute
        if ($request->has('product_attributes') && $request->product_attributes[0] != null) {
            foreach ($request->product_attributes as $attr_id) {
                $attribute_values = 'attribute_' . $attr_id . '_values';
                if ($request->has($attribute_values) && $request->$attribute_values != null) {
                    $p_attribute = new ProductAttribute;
                    $p_attribute->product_id = $product->id;
                    $p_attribute->attribute_id = $attr_id;
                    $p_attribute->save();

                    foreach ($request->$attribute_values as $val_id) {
                        $p_attr_value = new ProductAttributeValue;
                        $p_attr_value->product_id = $product->id;
                        $p_attr_value->attribute_id = $attr_id;
                        $p_attr_value->attribute_value_id = $val_id;
                        $p_attr_value->save();
                    }
                }
            }
        }


        $product->save();

        flash(translate('Product has been inserted successfully'))->success();
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backend.product.products.show', [
            'product' => Product::withCount('reviews', 'wishlists', 'carts')->with('variations.combinations')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product->shop_id != auth()->user()->shop_id) {
            abort(403);
        }

        $lang = $request->lang;
        $categories = Category::where('level', 0)->get();
        $all_attributes = Attribute::get();
        return view('backend.product.products.edit', compact('product', 'categories', 'lang', 'all_attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('is_variant') && !$request->has('variations')) {
            flash(translate('Invalid product variations'))->error();
            return redirect()->back();
        }

        $product                    = Product::findOrFail($id);
        $oldProduct                 = clone $product;

        if ($product->shop_id != auth()->user()->shop_id) {
            abort(403);
        }

        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $product->name          = $request->name;
            $product->unit          = $request->unit;
            $product->description   = $request->description;
        }

        $product->brand_id          = $request->brand_id;
        CoreComponentRepository::instantiateShopRepository();
        $product->min_qty           = $request->min_qty;
        $product->max_qty           = $request->max_qty;
        $product->photos            = $request->photos;
        $product->thumbnail_img     = $request->thumbnail_img;
        $product->published         = $request->status;

        // Product Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $product->id]);
        $product_translation->name          = $request->name;
        $product_translation->unit          = $request->unit;
        $product_translation->description   = $request->description;
        $product_translation->save();


        // SEO meta
        $product->meta_title        = (!is_null($request->meta_title)) ? $request->meta_title : $product->name;
        $product->meta_description  = (!is_null($request->meta_description)) ? $request->meta_description : strip_tags($product->description);
        $product->meta_image        = (!is_null($request->meta_image)) ? $request->meta_image : $product->thumbnail_img;
        $product->slug              = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));

        // warranty
        $product->has_warranty      = $request->has('has_warranty') && $request->has_warranty == 'on' ? 1 : 0;


        // tag
        $tags                       = array();
        if ($request->tags != null) {
            foreach (json_decode($request->tags) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags              = implode(',', $tags);

        // lowest highest price
        if ($request->has('is_variant') && $request->has('variations')) {
            $product->lowest_price  =  min(array_column($request->variations, 'price'));
            $product->highest_price =  max(array_column($request->variations, 'price'));
        } else {
            $product->lowest_price  =  $request->price;
            $product->highest_price =  $request->price;
        }

        // stock based on all variations
        $product->stock             = ($request->has('is_variant') && $request->has('variations')) ? max(array_column($request->variations, 'stock')) : $request->stock;

        // discount
        $product->discount          = $request->discount;
        $product->discount_type     = $request->discount_type;
        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime($date_var[1]);
        }

        // shipping info
        $product->standard_delivery_time    = $request->standard_delivery_time;
        $product->express_delivery_time     = $request->express_delivery_time;
        $product->weight                    = $request->weight;
        $product->height                    = $request->height;
        $product->length                    = $request->length;
        $product->width                     = $request->width;

        // category
        $product->categories()->sync($request->category_ids);

        // shop category ids
        $shop_category_ids = [];
        foreach ($request->category_ids ?? [] as $id) {
            $shop_category_ids[] = CategoryUtility::get_grand_parent_id($id);
        }
        $shop_category_ids =  array_merge(array_filter($shop_category_ids), $product->shop->shop_categories->pluck('category_id')->toArray());
        $product->shop->categories()->sync($shop_category_ids);

        // shop brand
        if ($request->brand_id) {
            ShopBrand::updateOrCreate([
                'shop_id' => $product->shop_id,
                'brand_id' => $request->brand_id,
            ]);
        }

        // taxes
        $tax_data = array();
        $tax_ids = array();
        if ($request->has('taxes')) {
            foreach ($request->taxes as $key => $tax) {
                array_push($tax_data, [
                    'tax' => $tax,
                    'tax_type' => $request->tax_types[$key]
                ]);
            }
            $tax_ids = $request->tax_ids;
        }
        $taxes = array_combine($tax_ids, $tax_data);

        $product->product_taxes()->sync($taxes);


        //product variation
        $product->is_variant        = ($request->has('is_variant') && $request->has('variations')) ? 1 : 0;

        if ($request->has('is_variant') && $request->has('variations')) {

            $requested_variations = collect($request->variations);
            $requested_variations_code = $requested_variations->pluck('code')->toArray();
            $old_variations_codes = $product->variations->pluck('code')->toArray();
            $old_matched_variations = $requested_variations->whereIn('code', $old_variations_codes);
            $new_variations = $requested_variations->whereNotIn('code', $old_variations_codes);


            // delete old variations that didn't requested
            $product->variations->whereNotIn('code', $requested_variations_code)->each(function ($variation) {
                foreach ($variation->combinations as $comb) {
                    $comb->delete();
                }
                $variation->delete();
            });

            // update old matched variations
            foreach ($old_matched_variations as $variation) {
                $p_variation              = ProductVariation::where('product_id', $product->id)->where('code', $variation['code'])->first();
                $p_variation->price       = $variation['price'];
                $p_variation->stock       = $variation['stock'];
                $p_variation->sku         = $variation['sku'];
                $p_variation->img         = $variation['img'];
                $p_variation->save();
            }


            // insert new requested variations
            foreach ($new_variations as $variation) {
                $p_variation              = new ProductVariation;
                $p_variation->product_id  = $product->id;
                $p_variation->code        = $variation['code'];
                $p_variation->price       = $variation['price'];
                $p_variation->stock       = $variation['stock'];
                $p_variation->sku         = $variation['sku'];
                $p_variation->img         = $variation['img'];
                $p_variation->save();

                foreach (array_filter(explode("/", $variation['code'])) as $combination) {
                    $p_variation_comb                         = new ProductVariationCombination;
                    $p_variation_comb->product_id             = $product->id;
                    $p_variation_comb->product_variation_id   = $p_variation->id;
                    $p_variation_comb->attribute_id           = explode(":", $combination)[0];
                    $p_variation_comb->attribute_value_id     = explode(":", $combination)[1];
                    $p_variation_comb->save();
                }
            }
        } else {
            // check if old product is variant then delete all old variation & combinations
            if ($oldProduct->is_variant) {
                foreach ($product->variations as $variation) {
                    foreach ($variation->combinations as $comb) {
                        $comb->delete();
                    }
                    $variation->delete();
                }
            }

            $variation              = $product->variations->first();
            $variation->product_id  = $product->id;
            $variation->code        = null;
            $variation->sku         = $request->sku;
            $variation->price       = $request->price;
            $variation->stock       = $request->stock;
            $variation->save();
        }


        // attributes + values
        foreach ($product->attributes as $attr) {
            $attr->delete();
        }
        foreach ($product->attribute_values as $attr_val) {
            $attr_val->delete();
        }
        if ($request->has('product_attributes') && $request->product_attributes[0] != null) {
            foreach ($request->product_attributes as $attr_id) {
                $attribute_values = 'attribute_' . $attr_id . '_values';
                if ($request->has($attribute_values) && $request->$attribute_values != null) {
                    $p_attribute = new ProductAttribute;
                    $p_attribute->product_id = $product->id;
                    $p_attribute->attribute_id = $attr_id;
                    $p_attribute->save();

                    foreach ($request->$attribute_values as $val_id) {
                        $p_attr_value = new ProductAttributeValue;
                        $p_attr_value->product_id = $product->id;
                        $p_attr_value->attribute_id = $attr_id;
                        $p_attr_value->attribute_value_id = $val_id;
                        $p_attr_value->save();
                    }
                }
            }
        }


        $product->save();

        flash(translate('Product has been updated successfully'))->success();
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->product_translations()->delete();
        $product->variations()->delete();
        $product->variation_combinations()->delete();
        $product->reviews()->delete();
        $product->product_categories()->delete();
        $product->carts()->delete();
        $product->offers()->delete();
        $product->wishlists()->delete();
        $product->attributes()->delete();
        $product->attribute_values()->delete();
        $product->taxes()->delete();

        if (Product::destroy($id)) {
            flash(translate('Product has been deleted successfully'))->success();
            return redirect()->route('product.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {
        $product = Product::find($id);
        $product_new = $product->replicate();
        $product_new->slug = Str::slug($product_new->name, '-') . '-' . strtolower(Str::random(5));

        if ($product_new->save()) {

            // variation duplicate
            foreach ($product->variations as $key => $variation) {
                $p_variation              = new ProductVariation;
                $p_variation->product_id  = $product_new->id;
                $p_variation->code        = $variation->code;
                $p_variation->price       = $variation->price;
                $p_variation->stock       = $variation->stock;
                $p_variation->sku         = $variation->sku;
                $p_variation->img         = $variation->img;
                $p_variation->save();

                // variation combination duplicate
                foreach ($variation->combinations as $key => $combination) {
                    $p_variation_comb                         = new ProductVariationCombination;
                    $p_variation_comb->product_id             = $product_new->id;
                    $p_variation_comb->product_variation_id   = $p_variation->id;
                    $p_variation_comb->attribute_id           = $combination->attribute_id;
                    $p_variation_comb->attribute_value_id     = $combination->attribute_value_id;
                    $p_variation_comb->save();
                }
            }

            // attribute duplicate
            foreach ($product->attributes as $key => $attribute) {
                $p_attribute                = new ProductAttribute;
                $p_attribute->product_id    = $product_new->id;
                $p_attribute->attribute_id  = $attribute->attribute_id;
                $p_attribute->save();
            }

            // attribute value duplicate
            foreach ($product->attribute_values as $key => $attribute_value) {
                $p_attr_value                       = new ProductAttributeValue;
                $p_attr_value->product_id           = $product_new->id;
                $p_attr_value->attribute_id         = $attribute_value->attribute_id;
                $p_attr_value->attribute_value_id   = $attribute_value->attribute_value_id;
                $p_attr_value->save();
            }

            // translation duplicate
            foreach ($product->product_translations as $key => $translation) {
                $product_translation                = new ProductTranslation;
                $product_translation->product_id    = $product_new->id;
                $product_translation->name          = $translation->name;
                $product_translation->unit          = $translation->unit;
                $product_translation->description   = $translation->description;
                $product_translation->lang          = $translation->lang;
                $product_translation->save();
            }

            //categories duplicate
            foreach ($product->product_categories as $key => $category) {
                $p_category                 = new ProductCategory;
                $p_category->product_id     = $product_new->id;
                $p_category->category_id    = $category->category_id;
                $p_category->save();
            }

            // taxes duplicate
            foreach ($product->taxes as $key => $tax) {
                $p_tax                = new ProductTax;
                $p_tax->product_id    = $product_new->id;
                $p_tax->tax_id        = $tax->tax_id;
                $p_tax->tax           = $tax->tax;
                $p_tax->tax_type      = $tax->tax_type;
                $p_tax->save();
            }

            flash(translate('Product has been duplicated successfully'))->success();
            return redirect()->route('product.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_subcategory(Request $request)
    {
        $products = Product::where('subcategory_id', $request->subcategory_id)->get();
        return $products;
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        $product->save();

        cache_clear();

        return 1;
    }

    public function sku_combination(Request $request)
    {
        // dd($request->all());

        $option_choices = array();

        if ($request->has('product_options')) {
            $product_options = $request->product_options;
            sort($product_options, SORT_NUMERIC);

            foreach ($product_options as $key => $option) {

                $option_name = 'option_' . $option . '_choices';
                $choices = array();

                if ($request->has($option_name)) {

                    $product_option_values = $request[$option_name];
                    sort($product_option_values, SORT_NUMERIC);

                    foreach ($product_option_values as $key => $item) {
                        array_push($choices, $item);
                    }
                    $option_choices[$option] =  $choices;
                }
            }
        }

        $combinations = array(array());
        foreach ($option_choices as $property => $property_values) {
            $tmp = array();
            foreach ($combinations as $combination_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = $combination_item + array($property => $property_value);
                }
            }
            $combinations = $tmp;
        }

        // dd($option_choices,$combinations);

        return view('backend.product.products.sku_combinations', compact('combinations'))->render();
    }

    public function new_attribute(Request $request)
    {
        $attributes = Attribute::query();
        if ($request->has('product_attributes')) {
            foreach ($request->product_attributes as $key => $value) {
                if ($value == NULL) {
                    return array(
                        'count' => -1,
                        'view' => view('backend.product.products.new_attribute', compact('attributes'))->render(),
                    );
                }
            }
            $attributes->whereNotIn('id', array_diff($request->product_attributes, [null]));
        }

        $attributes = $attributes->get();

        return array(
            'count' => count($attributes),
            'view' => view('backend.product.products.new_attribute', compact('attributes'))->render(),
        );
    }

    public function get_attribute_values(Request $request)
    {

        $attribute_id = $request->attribute_id;
        $attribute_values = AttributeValue::where('attribute_id', $attribute_id)->get();

        return view('backend.product.products.new_attribute_values', compact('attribute_values', 'attribute_id'));
    }

    public function new_option(Request $request)
    {

        $attributes = Attribute::query();
        if ($request->has('product_options')) {
            foreach ($request->product_options as $key => $value) {
                if ($value == NULL) {
                    return array(
                        'count' => -1,
                        'view' => view('backend.product.products.new_option', compact('attributes'))->render(),
                    );
                }
            }
            $attributes->whereNotIn('id', array_diff($request->product_options, [null]));
            if (count($request->product_options) === 3) {
                return array(
                    'count' => -2,
                    'view' => view('backend.product.products.new_option', compact('attributes'))->render(),
                );
            }
        }

        $attributes = $attributes->get();

        return array(
            'count' => count($attributes),
            'view' => view('backend.product.products.new_option', compact('attributes'))->render(),
        );
    }

    public function get_option_choices(Request $request)
    {

        $attribute_id = $request->attribute_id;
        $attribute_values = AttributeValue::where('attribute_id', $attribute_id)->get();

        return view('backend.product.products.new_option_choices', compact('attribute_values', 'attribute_id'));
    }
}
