<?php

namespace App\Http\Controllers\Web;

use App\Models\Variety;
use App\Models\CommodityMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Variety\VarietyStoreRequest;
use App\Http\Requests\Variety\VarietyUpdateRequest;


class VarietyController extends Controller
{
    const VIEW_DIR = "master.variety.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $items =  Variety::select(['id', 'name', 'commodity_id', 'created_at', 'status'])->with('commodity');


                if ($request->filled('date_from'))
                    $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
                if ($request->filled('date_to'))
                    $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));


                return datatables()::of($items)
                    ->addIndexColumn()
                    ->addColumn('action', '&nbsp;')
                    ->editColumn('action', function ($row) {
                        $routeKey = 'variety';
                        return view('template.action', compact('routeKey', 'row'))->render();
                    })
                    ->editColumn('created_at', function ($row) {
                        return displayDate($row->created_at);
                    })
                    ->editColumn('commodity_id', function ($row) {
                        return $row->commodity->name;
                    })
                    ->editColumn('status', function ($row) {
                        return sprintf(
                            '<span class="badge badge-pill badge-%s">%s</span>',
                            $row->status ? 'success' : 'danger',
                            $row->status ? 'Active' : 'In-active'
                        );
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }

            return view(self::VIEW_DIR . 'index');
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $commodities = CommodityMaster::where('status', true)->orderBy('name')->select('name', 'id')->get();

            return view(self::VIEW_DIR . 'create', compact('commodities'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VarietyStoreRequest $request)
    {
        try {

            $requestdata = $request->all();
            Variety::create($requestdata);
            return redirect('variety')->with('success', 'Varity Added Successfully');
        } catch (\Exception $e) {

            return redirect('variety')->with('error', 'Varity Create Failed');
        }
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
        try {

            $items = CommodityMaster::where('status', true)->orderBy('name')->select('name', 'id')->get();
            $variety = variety::with('commodity')->findOrFail($id);
            $items->prepend($variety->commodity->name, $variety->commodity->id);
            return view(self::VIEW_DIR . 'edit', compact('variety', 'items'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VarietyUpdateRequest $request, $id)
    {
        try {

            $requestdata = $request->all();


            $variety = Variety::findOrFail($id);
            $variety->update($requestdata);
            return redirect('variety')->with('success', 'Variety updated Successfully');
        } catch (\Exception $e) {

            return redirect('variety')->with('error', 'Variety update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $obj = Variety::destroy($id);



            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'false']);
        }
    }
}
