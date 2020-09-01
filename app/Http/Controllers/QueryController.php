<?php

namespace App\Http\Controllers;

use App\Queries;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    //
    public function querySave(Request $request)
    {
        $query = Queries::create([
            'query' => $request->get('query'),
            'status' => $request->get('status'),
            'status_code' => $request->get('status_code'),
            'user_id' => $request->get('user_id'),
            'query_time' => $request->get('query_time'),
            'result_length' => $request->get('result_length'),
        ]);

        $status = 'success';

        return response()->json(compact('query','status'), 201);

    }
}
