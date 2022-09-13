<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->is_super_admin) {
                $superAdmin = Auth::user()->id;
            }
            $items =  Notification::orderBy('id', 'desc')
                ->whereHas('users', function ($q) use ($superAdmin) {
                    $q->where('user_id', $superAdmin);
                    $q->where('user_type', 1);
                })->select(['id', 'item_type', 'item_id', 'title', 'created_at'])
                ->when($request->filled('from_date'), function ($q) use ($request) {
                    return $q->where('created_at', '>=', filterDate($request->from_date));
                })
                ->when($request->filled('to_date'), function ($q) use ($request) {
                    return $q->where('created_at', '<=', filterDate($request->to_date));
                });

            return datatables()::of($items)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return displayDate($row->created_at);
                })
                ->addColumn('action', function ($row) {

                    if (getItemTypeUrl($row->item_type) == 'farmer') {
                        $cUrl = getItemTypeUrl($row->item_type) . "/" . "?farmer_id=" . $row->item_id . "&n_id=" . $row->id;
                    } elseif (getItemTypeUrl($row->item_type) == 'deleted_accounts') {
                        $cUrl = getItemTypeUrl($row->item_type);
                    } else {
                        $cUrl =  getItemTypeUrl($row->item_type) . "/" . $row->item_id . '/?n_id=' . $row->id;
                    }
                    $btn = '
                    <a href=' . "{$cUrl}" . ' class="edit btn btn-primary btn-sm editNews"><i class="far fa-eye"></i></a>
                       ';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('notifications.index');
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
}
