<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\CountryMaster;
use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryMasterEditRequest;
use App\Http\Requests\Country\CountryMasterCreateRequest;

class CountryMasterController extends Controller
{
    const VIEW_DIR = "master.country.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $items =  CountryMaster::select(['id', 'name','language','created_at', 'status']);
               

                 if($request->filled('date_from'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
                if($request->filled('date_to'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));


                return datatables()::of($items)
                        ->addIndexColumn()
                        ->addColumn('action','&nbsp;')
                        ->editColumn('action', function ($row) {
                            $routeKey = 'country';
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
                        ->rawColumns(['action','status'])
                        ->make(true);
            }
          
            return view(self::VIEW_DIR.'index');
        }catch(\Exception $e) {

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
        try
        {

          return view(self::VIEW_DIR.'create');
          }
     catch(\Exception $e) {
      
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryMasterCreateRequest $request)
    {
        try
        { 
        $data=$request->validated();
        
        CountryMaster::create($data); 
        return redirect()->route('country.index')->with('success','Country Added Successfully'); 
      }
     catch(\Exception $e) {
       
      return redirect()->back()->withInput()->with('error','Country create Failed');
            // return $e->getMessage();
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
    public function edit(CountryMaster $country)
    {
        try
        {
        return view(self::VIEW_DIR.'edit',compact('country'));    
        }
     catch(\Exception $e) {
      
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
    public function update(CountryMasterEditRequest $request,CountryMaster $country)
    {
        try
        {
           
        $data=$request->validated();
      
        $country->update($data);
        return redirect()->route('country.index')->with('success','Country updated Successfully'); 
      }
         catch(\Exception $e) {
      
        return redirect()->route('country.index')->with('error','Country update Failed'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CountryMaster $country)
    {
        try{
            $obj = $country->delete();
            return response()->json(['status'=>'true']);
        }catch(\Exception $e) {
         
             return response()->json(['status'=>'false']);
        } 
    }
}
