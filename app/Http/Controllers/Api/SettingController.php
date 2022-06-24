<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AllCategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SettingsCollection;
use App\Http\Resources\ShopCollection;
use App\Models\AppSettings;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Cache;

class SettingController extends Controller
{
    public function index()
    {
        // return new SettingsCollection(AppSettings::all());
    }
    public function home_setting($section)
    {   
        switch ($section) {
            case 'sliders':
                $data = Cache::remember('sliders', 86400, function () {
                    return [
                        'one' => get_setting('home_slider_1_images')
                                    ? banner_array_generate(get_setting('home_slider_1_images'),get_setting('home_slider_1_links'))
                                    : [],
                        'two' => get_setting('home_slider_2_images')
                                    ? banner_array_generate(get_setting('home_slider_2_images'),get_setting('home_slider_2_links'))
                                    : [],
                        'three' => get_setting('home_slider_3_images')
                                    ? banner_array_generate(get_setting('home_slider_3_images'),get_setting('home_slider_3_links'))
                                    : [],
                        'four' => get_setting('home_slider_4_images')
                                    ? banner_array_generate(get_setting('home_slider_4_images'),get_setting('home_slider_4_links'))
                                    : [],
                        ];
                });
                break;

            case 'popular_categories':
                $data = Cache::remember('popular_categories', 86400, function () {
                    return get_setting('home_popular_categories')
                            ? new CategoryCollection(Category::whereIn('id', json_decode(get_setting('home_popular_categories')))->get())
                            : [];
                });
                break;

            case 'product_section_one':
                $data = Cache::remember('product_section_one', 86400, function () {
                    $product_section_1_products = get_setting('home_product_section_1_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_1_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_1_title'),
                        'products' => new ProductCollection($product_section_1_products)
                    ];
                });
                break;

            case 'product_section_two':
                $data = Cache::remember('product_section_two', 86400, function () {
                    $product_section_2_products = get_setting('home_product_section_2_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_2_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_2_title'),
                        'products' => new ProductCollection($product_section_2_products)
                    ];
                });
                break;

            case 'product_section_three':
                $data = Cache::remember('product_section_three', 86400, function () {
                    $product_section_3_products = get_setting('home_product_section_3_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_3_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_3_title'),
                        'banner' => [
                            'img' => api_asset(get_setting('home_product_section_3_banner_img')),
                            'link' => get_setting('home_product_section_3_banner_link')
                        ],
                        'products' => new ProductCollection($product_section_3_products)
                    ];
                });
                break;

            case 'product_section_four':
                $data = Cache::remember('product_section_four', 86400, function () {
                    $product_section_4_products = get_setting('home_product_section_4_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_4_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_4_title'),
                        'products' => new ProductCollection($product_section_4_products)
                    ];
                });
                break;

            case 'product_section_five':
                $data = Cache::remember('product_section_five', 86400, function () {
                    $product_section_5_products = get_setting('home_product_section_5_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_5_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_5_title'),
                        'products' => new ProductCollection($product_section_5_products)
                    ];
                });
                break;

            case 'product_section_six':
                $data = Cache::remember('product_section_six', 86400, function () {
                    $product_section_6_products = get_setting('home_product_section_6_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_6_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_6_title'),
                        'banner' => [
                            'img' => api_asset(get_setting('home_product_section_6_banner_img')),
                            'link' => get_setting('home_product_section_6_banner_link')
                        ],
                        'products' => new ProductCollection($product_section_6_products)
                    ];
                });
                break;

            case 'banner_section_one':
                $data = get_setting('home_banner_1_images')
                            ? banner_array_generate(get_setting('home_banner_1_images'),get_setting('home_banner_1_links'))
                            : [];
                break;

            case 'banner_section_two':
                $data = get_setting('home_banner_2_images')
                            ? banner_array_generate(get_setting('home_banner_2_images'),get_setting('home_banner_2_links'))
                            : [];
                break;

            case 'banner_section_three':
                $data = get_setting('home_banner_3_images')
                            ? banner_array_generate(get_setting('home_banner_3_images'),get_setting('home_banner_3_links'))
                            : [];
                break;

            case 'banner_section_four':
                $data = get_setting('home_banner_4_images')
                            ? banner_array_generate(get_setting('home_banner_4_images'),get_setting('home_banner_4_links'))
                            : [];
                break;

            case 'home_about_text':
                $data = get_setting('home_about_us');
                break;

            case 'shop_section_one':
                $data = Cache::remember('shop_section_one', 86400, function () {
                    $shop_section_1_shops = get_setting('home_shop_section_1_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_1_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_1_title'),
                        'shops' => new ShopCollection($shop_section_1_shops, true)
                    ];
                });
                break;

            case 'shop_banner_section_one':
                $data = get_setting('home_shop_banner_1_images')
                            ? banner_array_generate(get_setting('home_shop_banner_1_images'),get_setting('home_shop_banner_1_links'))
                            : [];
                break;

            case 'shop_section_two':
                $data = Cache::remember('shop_section_two', 86400, function () {
                    $shop_section_2_shops = get_setting('home_shop_section_2_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_2_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_2_title'),
                        'shops' => new ShopCollection($shop_section_2_shops, true)
                    ];
                });
                break;

            case 'shop_banner_section_two':
                $data = get_setting('home_shop_banner_2_images')
                            ? banner_array_generate(get_setting('home_shop_banner_2_images'),get_setting('home_shop_banner_2_links'))
                            : [];
                break;

            case 'shop_section_three':
                $data = Cache::remember('shop_section_three', 86400, function () {
                    $shop_section_3_shops = get_setting('home_shop_section_3_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_3_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_3_title'),
                        'shops' => new ShopCollection($shop_section_3_shops, true)
                    ];
                });
                break;
            case 'shop_section_four':
                $data = Cache::remember('shop_section_four', 86400, function () {
                    $shop_section_4_shops = get_setting('home_shop_section_4_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_4_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_4_title'),
                        'shops' => new ShopCollection($shop_section_4_shops, true)
                    ];
                });
                break;
            case 'shop_section_five':
                $data = Cache::remember('shop_section_five', 86400, function () {
                    $shop_section_5_shops = get_setting('home_shop_section_5_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_5_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_5_title'),
                        'shops' => new ShopCollection($shop_section_5_shops, true)
                    ];
                });
                break;
            case 'shop_banner_section_three':
                $data = get_setting('home_shop_banner_3_images')
                            ? banner_array_generate(get_setting('home_shop_banner_3_images'),get_setting('home_shop_banner_3_links'))
                            : [];
                break;

            default:
                $data = null;
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function header_setting()
    {
        return Cache::remember('header_setting', 86400, function () {
            return response()->json([
                'top_banner' => [
                    'img' => api_asset(get_setting('topbar_banner')),
                    'link' => get_setting('topbar_banner_link')
                ],
                'mobile_app_links' => [
                    'play_store' => get_setting('topbar_play_store_link'),
                    'app_store' => get_setting('topbar_app_store_link'),
                ],
                'helpline' => get_setting('topbar_helpline_number'),
                'header_menu' => get_setting('header_menu_labels') !== null
                            ? array_combine(json_decode(get_setting('header_menu_labels')),json_decode(get_setting('header_menu_links')))
                            : []
            ]);
        });
    }  
    public function footer_setting()
    {   
        return Cache::remember('footer_setting', 86400, function () {
            return response()->json([
                'footer_logo' => api_asset(get_setting('footer_logo')),
                'footer_link_one' => [
                    'title' => get_setting('footer_link_one_title'),
                    'menu' => get_setting('footer_link_one_labels') !== null
                                ? array_combine(json_decode(get_setting('footer_link_one_labels')),json_decode(get_setting('footer_link_one_links')))
                                : []
                ],
                'footer_link_two' => [
                    'title' => get_setting('footer_link_two_title'),
                    'menu' => get_setting('footer_link_two_labels') !== null
                                ? array_combine(json_decode(get_setting('footer_link_two_labels')),json_decode(get_setting('footer_link_two_links')))
                                : []
                ],
                'contact_info' => [
                    'contact_address' => get_setting('contact_address'),
                    'contact_email' => get_setting('contact_email'),
                    'contact_phone' => get_setting('contact_phone'),
                ],
                'mobile_app_links' => [
                    'play_store' => get_setting('play_store_link'),
                    'app_store' => get_setting('app_store_link'),
                ],
                'footer_menu' => get_setting('footer_menu_labels') !== null
                        ? array_combine(json_decode(get_setting('footer_menu_labels')),json_decode(get_setting('footer_menu_links')))
                        : [],
                'copyright_text' => get_setting('frontend_copyright_text'),
                'social_link' => get_setting('footer_social_link')
                                        ? json_decode(get_setting('footer_social_link'), true)
                                        : ['facebook-f' => null,'twitter' => null,'instagram' => null,'youtube' => null,'linkedin-in' => null],
            ]);
        });
    }
}
