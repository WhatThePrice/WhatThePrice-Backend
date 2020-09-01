<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\User;
use App\QueryPrice;
use App\QueryTracker;
use App\ProductPrice;
use App\ProductTracker;

class PriceController extends Controller
{
//////_____SAVE QUERY PRICE_____///////////////////////////////////////////////////
    public function saveQueryPrice(Request $request)
    {
        $query_price = QueryPrice::create([
            'query_tracker_id' => $request->get('query_tracker_id'),
            'price_analytics' => $request->get('price_analytics'),
        ]);

        $status = 'success';

        return response()->json(compact('query_price'), 201);
    }

//////_____SAVE PRODUCT PRICE_____///////////////////////////////////////////////////
    public function saveProductPrice(Request $request)
    {
        $product_price = ProductPrice::create([
            'product_tracker_id' => $request->get('product_tracker_id'),
            'price' => $request->get('price'),
        ]);

        return response()->json(compact('product_price'), 201);
    }

//////_____GET QUERY PRICE_____///////////////////////////////////////////////////
    public function getQueryPrice(){

        $id = JWTAuth::parseToken()->authenticate()->id;

        $query_price = DB::table('users')
                    ->rightJoin('query_trackers', 'query_trackers.user_id', '=', 'users.id')
                    ->join('query_prices', 'query_prices.query_tracker_id', '=', 'query_trackers.id')
                    ->select('users.name', 'query_trackers.id', 'query_trackers.query','query_prices.price_analytics->max_price as max_price',
                            'query_prices.price_analytics->avg_price as avg_price',
                            'query_prices.price_analytics->min_price as min_price',
                            'query_prices.price_analytics->min_price as min_price',
                            'query_prices.price_analytics->median_price as median_price',
                            'query_prices.created_at')
                    ->where('users.id', $id)
                    ->get();

        // $query_price = DB::table('query_prices')
        //                 ->select('price_analytics->max_price as max')
        //                 ->get();


        $status = 'success';

        return response()->json(compact('query_price','status','id'),201);
    }

//////_____GET PRODUCT PRICE_____///////////////////////////////////////////////////
    public function getProductPrice(){

        $id = JWTAuth::parseToken()->authenticate()->id;

        $product_price = User::rightJoin('product_trackers', 'product_trackers.user_id', '=', 'users.id')
                    ->join('product_prices', 'product_prices.product_tracker_id', '=', 'product_trackers.id')
                    ->select('users.name', 'product_trackers.id', 'product_trackers.product_name', 'product_trackers.product_url','product_prices.price', 'product_prices.created_at')
                    ->where('users.id', $id)
                    ->get();


        $status = 'success';

        return response()->json(compact('product_price','status','id'),201);
    }
}
