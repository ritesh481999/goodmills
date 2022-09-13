<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use Auth;
use App\Utils\Error;
use App\Models\OSFixing;
use App\Models\Weight;

class ContractController extends Controller
{
    private $model;
    private $osfixing;
    private $weight;

    public function __construct()
    {
        $this->model = new Contract;
        $this->osfixing = new OSFixing;
        $this->weight = new Weight;
    }

    public function getAllContract(Request $request)
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
        ->whereBetween('cmc_period', [$date])
        ->where('cmc_account', $farmer->farmer->mb_account)
        ->orderBy('cmc_period','desc')
        ->select([
            'cmc_id as Id',
            'cmc_contract as Contractid',
            'cmc_commodity as Commodity',
            'cmc_variety as Variety',
            'cmc_date as Date',
            'cmc_period as Period',
            'cmc_tonnage as Tonnage',
            'cmc_qty_delivered as Delivered',
            'cmc_rate as Rate',
            'cmc_status as Status'
        ]);
        config(['common.api_max_result_set'=>10]);

        return apiPaginationResponse(
            $model, 
            $request->page ?? 1,
            'Returning contract List'
        );
    }

    public function getContractDetail($contract_id)
    { 
        $model = $this->model
        ->where('cmc_contract', $contract_id)
        ->select([
            'cmc_id as Id',
            'cmc_contract as Contractid',
            'cmc_commodity as Commodity',
            'cmc_variety as Variety',
            'cmc_date as Date',
            'cmc_period as Period',
            'cmc_tonnage as Tonnage',
            'cmc_qty_delivered as Delivered',
            'cmc_rate as Rate',
            'cmc_status as Status'

        ]);
        config(['common.api_max_result_set'=>10]);

        return apiPaginationResponse(
            $model, 
            $request->page ?? 1,
            'Returning Contract Detail'
        );
    }

    public function getOsFixingDetail(Request $request)
    {
        $farmer = $request->user();
        $this->validate($request, [
            'contract_id' => 'required'
        ]);
        $model = $this->osfixing
        ->where('fx_contract',$request->contract_id)
        ->where('fx_account',$farmer->farmer->mb_account)
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

        return apiPaginationResponse(
            $model, 
            $request->page ?? 1,
            'Returning Os/Fixing Details'
        );
    }
}
