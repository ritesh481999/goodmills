<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Models\DeliveryLocation;
use App\Http\Requests\Dropoff\DeliveryStoreRequest;
use App\Http\Requests\Dropoff\DropoffUpdateRequest;
class DeliveryLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $items =  DeliveryLocation::select(['id', 'name','created_at', 'status'])->orderBy('id','desc');
               

                 if($request->filled('date_from'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
                if($request->filled('date_to'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));


                return datatables()::of($items)
                        ->addIndexColumn()
                        ->addColumn('action','&nbsp;')
                        ->editColumn('action', function ($row) {
                            $routeKey = 'delivery_location';
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
          
            return view('master.delivery_location.index');
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

          return view('master.delivery_location.create');
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
    public function store(DeliveryStoreRequest $request)
    {
         try
        { 
            
        $requestdata=$request->all();
        DeliveryLocation::create($requestdata); 
        return redirect()->route('delivery_location.index')->with('success','Delivery Location Added Successfully'); 
      }
     catch(\Exception $e) {
      return redirect()->route('delivery_location.index')->with('error','Delivery Location create Failed');
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
    public function edit($id)
    {
         try
        {
      
        $dropoff=DeliveryLocation::findOrFail($id);
        return view('master.delivery_location.edit',compact('dropoff'));    
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
    public function update(DropoffUpdateRequest $request, $id)
    {
         try
        {
           
        $requestdata=$request->all();
        

        $dropoff= DeliveryLocation::findOrFail($id);
        $dropoff->update($requestdata); 
        return redirect()->route('delivery_location.index')->with('success','Delivery Location updated Successfully'); 
      }
         catch(\Exception $e) {
      
        return redirect()->route('delivery_location.index')->with('error','Delivery Location update Failed'); 
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
       try{
            $obj = DeliveryLocation::destroy($id);
             return response()->json(['status'=>'true']);
        }catch(\Exception $e) {
         
             return response()->json(['status'=>'false']);
        } 
    }
}
