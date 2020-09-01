<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
Use App\QueryTracker;
Use App\ProductTracker;

class TrackerController extends Controller
{
//////_____SAVE QUERY TRACKER_____///////////////////////////////////////////////////
    public function saveQueryTracker(Request $request)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;

        $query = QueryTracker::create([
            'user_id' => $user_id,
            'query' => $request->get('query'),
        ]);

        $status = 'success';

        return response()->json(compact('query','status'), 201);
    }

//////_____SAVE PRODUCT TRACKER_____///////////////////////////////////////////////////
    public function saveProductTracker(Request $request)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;

        $product = ProductTracker::create([
            'user_id' => $user_id,
            'product_url' => $request->get('product_url'),
            'product_name' => $request->get('product_name'),
        ]);

        $status = 'success';

        return response()->json(compact('product','status'), 201);
    }

//////_____CANCEL QUERY TRACKER_____///////////////////////////////////////////////////
    public function cancelQueryTracker(Request $request)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;

        $query_cancel = QueryTracker::where('user_id', $user_id)
                            ->where('query', $request->get('query'))
                            ->update(['track_status'=>'no']);

        if($query_cancel == 1){
            $status = 'success';
        }
        else {
            $status = 'update fail';
        }

        return response()->json(compact('query_cancel','status'), 201);
    }

//////_____CANCEL PRODUCT TRACKER_____///////////////////////////////////////////////////
    public function cancelProductTracker(Request $request)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;

        $product_cancel = ProductTracker::where('user_id', $user_id)
                            ->where('product_url', $request->get('product_url'))
                            ->update(['track_status'=>'no']);

        if($product_cancel == 1){
            $status = 'success';
        }
        else {
            $status = 'update fail';
        }

        return response()->json(compact('product_cancel','status'), 201);
    }

//////_____RETRIEVE QUERY TRACKER LIST_____///////////////////////////////////////////////////
    public function getQueryTracker(Request $request)
    {
        $query_list = DB::table('query_trackers')->select('id', 'query')->where('track_status','yes')->get();

        $status = 'success';

        return response()->json(compact('query_list','status'), 201);
    }

//////_____RETRIEVE PRODUCT TRACKER LIST_____///////////////////////////////////////////////////
    public function getProductTracker(Request $request)
    {
        $product_list = DB::table('product_trackers')->select('id', 'product_url')->where('track_status','yes')->get();

        $status = 'success';

        return response()->json(compact('product_list','status'), 201);
    }
}
