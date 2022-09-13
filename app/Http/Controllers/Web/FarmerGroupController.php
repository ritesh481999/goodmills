<?php

namespace App\Http\Controllers\Web;

use App\Models\FarmerGroup;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FarmerGroupRequest;
use App\Models\CountryMaster;
use App\Models\FAQ;

class FarmerGroupController extends Controller
{
    const VIEW_DIR = "farmer_group.";
    private $model;

    public function __construct()
    {
        $this->model = new FarmerGroup;
    }

    public function index(Request $request)
    {
            if ($request->ajax())
            {
                $items =  FarmerGroup::select(['id', 'name','country_id','created_at', 'status'])->with('country:id,name')->orderBy('id', 'desc');
                if ($request->filled('from_date'))
                    $items = $items->whereDate('created_at', '>=', filterDate($request->from_date));
                if ($request->filled('to_date'))
                    $items = $items->whereDate('created_at', '<=', filterDate($request->to_date));
                if ($request->filled('country_id'))
                    $items = $items->where('country_id', $request->country_id);
                return datatables()::of($items)
                    ->addIndexColumn()
                    ->editColumn('no_of_farmers', function ($row) {
                        return $row->farmers()->count();
                    })
                    ->editColumn('country_id', function ($row) {
                        return $row->country->name;
                    })
                    ->editColumn('created_at', function ($row) {
                        return displayDate($row->created_at);
                    })
                    ->make(true);
            }
            $countries = CountryMaster::pluck('name', 'id')->toArray();
            return view(self::VIEW_DIR . 'index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->ajax())

            return view(self::VIEW_DIR . 'create');
        try {
            $items = Farmer::select(['id', 'username'])->whereHas('countries', function ($q) {
                $q->where('country_farmer.status', 1);
                $q->where('country_farmer.country_id', auth()->user()->selected_country_id);
            })->active()->orderBy('id', 'desc');
            return datatables()::of($items)
                ->make(true);
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
    public function store(FarmerGroupRequest $request)
    {

        $res = [];
        try {
            $farmer_ids = explode(',', $request->farmer_ids);
            if (count($farmer_ids) > 1) {
                $data = $request->validated();
                $data['country_id'] = auth()->user()->selected_country_id;
                $farmer_group = $this->model->create($data);
                $farmer_group->farmers()->attach($farmer_ids);
                $res['success'] = 'Farmer group saved successfully';
            } else {
                return redirect()->back()->with('error', __('common.farmer_group.farmer_group_not_created_validation'));
            }
        } catch (\Exception $e) {
            throw $e;
            return $res['error'] = 'Farmer group failed';
        }
        return redirect()->route('farmer_group.index')->with($res);
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
    public function edit(FarmerGroup $farmer_group)
    {
        try {
            $farmers = [];
            $farmers = Farmer::select(['id', 'username'])->get()->toArray();
            $farmers_added_group = $farmer_group->farmers()->select(['id', 'username'])->get()->toArray();
            // $farmers_not_ids = array_diff(array_column($farmers, 'id'), array_column($farmers_added_group, 'id'));

            return view(self::VIEW_DIR . 'edit')->with(['group' => $farmer_group, 'farmers' => $farmers_added_group]);
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
    public function update(FarmerGroupRequest $request, FarmerGroup $farmer_group)
    {
        $res = [];
        try {
            $farmer_ids = explode(',', $request->farmer_ids);

            $farmer_group->update($request->validated());
            $farmer_group->farmers()->sync($farmer_ids);
            $res['success'] = 'Farmer group updated successfully';
        } catch (\Exception $e) {
            throw $e;
            return $res['error'] = 'Farmer group failed';
        }
        return redirect()->route('farmer_group.index')->with($res);
    }
}
