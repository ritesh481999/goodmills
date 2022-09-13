<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commodity\CommodityCreateRequest;
use App\Http\Requests\Commodity\CommodityEditRequest;

use App\Models\Variety;
use App\Models\CommodityMaster;
use App\Models\SpecificationMaster;

class CommodityMasterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = CommodityMaster::select(['id', 'name', 'created_at', 'status'])->orderBy('id','desc');

            if ($request->from_date) {
                $items = $items->whereDate('created_at', '>=', filterDate($request->from_date));
            }

            if ($request->to_date) {
                $items = $items->whereDate('created_at', '<=', filterDate($request->to_date));
            }

            return datatables()::of($items)
                ->addIndexColumn()
                ->addColumn('action','&nbsp;')
                ->editColumn('action', function ($row) {
                    $routeKey = 'commodity';
                    return view('template.action',compact('routeKey','row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return displayDate($row->created_at);
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

        return view('master.commodity.index');
    }

    public function create()
    {
        return view('master.commodity.create');
    }
    public function store(CommodityCreateRequest $request)
    {
        CommodityMaster::create($request->validated());

        return redirect()->route('commodity.index')->with('success', 'Commodity Detail Created Successfully');
    }

    public function edit(Request $request, CommodityMaster $commodity)
    {
        return view('master.commodity.edit', compact('commodity'));
    }

    public function update(CommodityEditRequest $request, CommodityMaster $commodity)
    {
        $commodity->update($request->validated());

        if ($request->status == 0) {
            Variety::where('commodity_id', $commodity->id)
                ->update(['status' => 0]);
            SpecificationMaster::where('commodity_id', $commodity->id)
                ->update(['status' => 0]);
        }

        return redirect()->route('commodity.index')->with('success', 'Commodity Detail Updated Successfully');
    }

    public function destroy(CommodityMaster $commodity)
    {
      
        $variety = Variety::where('commodity_id', $commodity->id)
            ->get();

        $specification = SpecificationMaster::where('commodity_id', $commodity->id)
            ->get();

        if ((count($variety)) || (count($specification))) {
            $msg = "This commodity has been used in ";

            if ((count($variety)) && (count($specification))) {
                $msg .= count($variety) . " varieties and " . count($specification) . " specifications";
            } else {
                if (count($variety))
                    $msg .= count($variety) . " varieties";
                if (count($specification))
                    $msg .= count($specification) . " specifications";
            }

            return response()->json(['status' => 'false', 'message' => $msg]);
        }

        $commodity->delete();

        return response()->json(['status' => 'true']);
    }
}
