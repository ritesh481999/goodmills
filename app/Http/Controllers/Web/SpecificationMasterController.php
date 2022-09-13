<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpecificationMasterCreateRequest;
use App\Models\SpecificationMaster;
use App\Models\CommodityMaster;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SpecificationMasterController extends Controller
{
    const VIEW_DIR = "master.specification.";
    private $model;

    public function __construct()
    {
        $this->model = new SpecificationMaster;
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $items = $this->model
            ->with('commodity')
            ->select(['id', 'name', 'commodity_id','created_at', 'status'])
            ->orderBy('id','desc');

            if($request->filled('date_from'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
            if($request->filled('date_to'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));
            
            return Datatables::of($items)
                    ->addIndexColumn()
                    ->addColumn('action','&nbsp;')
                    ->editColumn('action', function ($row) {
                        $routeKey = 'specification';
                        return view('template.action',compact('routeKey','row'))->render();
                    })
                    ->editColumn('created_at', function($row){
                        return displayDate($row->created_at);
                    })
                    ->editColumn('status', function($row){
                        return sprintf('<span class="badge badge-pill badge-%s">%s</span>', 
                            $row->status ? 'success' : 'danger',
                            $row->status ? 'Active' : 'In-active'
                        );
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true); 
        }
        
        return view(self::VIEW_DIR.'index');
    }

    public function create()
    {
        $commodities = CommodityMaster::where('status',true)->orderBy('id', 'desc')
        ->select('id', 'name')
        ->get();
        return view(self::VIEW_DIR.'create', compact('commodities'));
    }

    public function edit($id)
    {
        $item = $this->model->with('commodity')->findOrFail($id);
        $commodities = CommodityMaster::where('status',true)->orderBy('id', 'desc')
        ->select('id', 'name')
        ->get();
        return view(self::VIEW_DIR.'edit', compact('item','commodities'));
    }

    public function store(SpecificationMasterCreateRequest $request)
    {
        $data = $request->validated();
        
        $model = $this->model;
        DB::transaction(function () use($model, $data){
            $model->create($data);
        });
        return redirect()->route('specification.index')->withSuccess('Specification added successfully');
    }

    public function update(SpecificationMasterCreateRequest $request,SpecificationMaster $specification)
    {
        
        
        $specification->update( $request->validated());
        return redirect()->route('specification.index')->withSuccess('Specification updated successfully');
    }

    public function destroy(SpecificationMaster $specification)
    {   
        
        $specification->delete();
        return response()->json(['status'=>'true']);
    }
}