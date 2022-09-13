<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeletedAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items =  Farmer::onlyTrashed()->orderBy('deleted_at', 'desc')->when($request->filled('from_date'), function ($q) use ($request) {
                return $q->where('created_at', '>=', filterDate($request->from_date));
            })
                ->when($request->filled('to_date'), function ($q) use ($request) {
                    return $q->where('created_at', '<=', filterDate($request->to_date));
                });

            return datatables()::of($items)
                ->addIndexColumn()

                ->editColumn('deleted_at', function ($row) {
                    return displayDate($row->deleted_at);
                })->addColumn('password', function () {
                    return  "XXXXXX";
                })
                ->addColumn('age', function ($row) {
                    return Carbon::parse($row->deleted_at)->diffForHumans();
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                        <a href="javascript:void(0)" data-id=' . $row->id . ' class="restore btn btn-danger btn-sm restoreFarmer"><i class="fas fa-trash-restore"></i></a>
                       ';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('deleted_accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function restore($id)
    {
       
        DB::beginTransaction();
        try {
            Farmer::withTrashed()->find($id)->restore();
            DB::commit();

            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'false']);
        }
    }
}
