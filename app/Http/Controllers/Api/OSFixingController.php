<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OSFixing;
use Auth;
use App\Utils\Error;

class OSFixingController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new OSFixing;
    }

    public function getAll(Request $request)
    {
        $farmer = $request->user();
        if($request->filled('date_from') && !$request->filled('date_to'))
            Error::error('From date and to date both must be selected.');
        if(!$request->filled('date_from') && $request->filled('date_to'))
            Error::error('From date and to date both must be selected.');

        if($request->filled('date_from') && $request->filled('date_to'))
        {
            $date = [
                'from' => $request->input('date_from'),
                'to' => $request->input('date_to')
            ];
        }else{
            $now = now();
            $date = [
                'from' => $now->copy()->subQuarter()->toDateString(),
                'to' => $now->toDateString()
            ];
        }
        
        $model = $this->model
        ->whereBetween('fx_date', [$date])
        ->where('fx_account',$farmer->farmer->mb_account)
        ->where('fx_delivered', 0)
        ->orderBy('fx_date','desc')
        ->select([
            'fx_id as id',
            'fx_contract as contract',
            'fx_stock_desc as stock_description',
            'fx_date as date',
            'fx_haulier as haulier',
            'fx_fix_ref as fix_ref',
            'fx_delivered as delivered',
            'fx_qty as wieght'
        ]);

        config(['common.api_max_result_set'=>10]);

        return apiPaginationResponse(
            $model, 
            $request->page ?? 1,
            'Returning O/S Fixing List'
        );
    }
}