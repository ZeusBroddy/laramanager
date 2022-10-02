<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Cashier;

class StripeController extends Controller
{
    public static function products()
    {
        $stripe = Cashier::stripe();
        $products = $stripe->products->all(); // here you get all products
        $prices   = $stripe->prices->all();   // here you get all prices

        $items = []; // init empty array

        // Loop though each product and create your own schema
        foreach ($products->data as $product) :
            $key = $product->id;
            // $tier = strtolower($product->name);
            $items[$key] = [];
            $items[$key]['id']   = $product->id;
            // $items[$key]['tier'] = $tier;
            $items[$key]['name'] = $product->name;
            $items[$key]['metakey'] = $product->metadata;

            $items[$key]['price_details'] = ['id' => null, 'price' => null];
        endforeach;

        // now we need to add the existing prices for the products
        foreach ($prices->data as $price) :
            if ($price->active == false) continue; // skip all archived prices

            $key = $price->product;
            $items[$key]['price_details']['id'] = $price->id;
            $items[$key]['price_details']['price'] = $price->unit_amount / 100;
            $items[$key]['price_details']['interval'] = $price->recurring->interval;
        endforeach;

        // return response()->json([
        //     'items' => $items,          // I work with my products <> price bindings here
        //     // 'products'  => $products,   // stripe response for products
        //     // 'prices'    => $prices,     // stripe response for prices
        // ]);

        return $items;
    }

    // public static function products()
    // {
    //     $stripeProducts = Http::withToken(config('services.stripe.secret'))
    //         ->get('https://api.stripe.com/v1/products')
    //         ->json()['data'];

    //     $stripePrices = Http::withToken(config('services.stripe.secret'))
    //         ->get('https://api.stripe.com/v1/prices')
    //         ->json()['data'];
    // }
}
