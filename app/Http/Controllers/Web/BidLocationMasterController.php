<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BidLocationMasterCreateRequest;
use App\Models\BidLocationMaster;

use Yajra\DataTables\DataTables;

use DB;

class BidLocationMasterController extends Controller
{
    const VIEW_DIR = "bid_location.";
    private $model;

    public function __construct()
    {
        $this->model = new BidLocationMaster;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = $this->model
                ->select(['id', 'name', 'created_at', 'status']);

            if ($request->filled('date_from'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
            if ($request->filled('date_to'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));

            return Datatables::of($items)
                ->addIndexColumn()
                ->addColumn('action', '&nbsp;')
                ->editColumn('action', function ($row) {
                    $routeKey = 'bid_location';
                    return view('template.action', compact('routeKey', 'row'))->render();
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

        return view(self::VIEW_DIR . 'index');
    }

    public function create()
    {
        return view(self::VIEW_DIR . 'create');
    }

    public function edit($id)
    {
        $item = $this->model->findOrFail($id);
        return view(self::VIEW_DIR . 'edit', compact('item'));
    }

    public function store(BidLocationMasterCreateRequest $request)
    {
        $data = $request->validated();
        $model = $this->model;
        DB::transaction(function () use ($model, $data) {
            $model->create($data);
        });
        return redirect()->route('bid_location.index')->withSuccess('Bid location added successfully');
    }

    public function update(BidLocationMasterCreateRequest $request, $id)
    {
        $item = $this->model->findOrFail($id);
        $data = $request->validated();
        DB::transaction(function () use ($item, $data) {
            $item->update($data);
        });
        return redirect()->route('bid_location.index')->withSuccess('Bid location updated successfully');
    }

    public function destroy(BidLocationMaster $bidLocation)
    {   
        $bidLocation->delete();
        return response()->json(['status' => 'true']);
    }
}
