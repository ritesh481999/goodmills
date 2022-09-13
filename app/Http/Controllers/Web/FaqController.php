<?php

namespace App\Http\Controllers\Web;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\faqstorerequest;
use App\Http\Requests\Faq\faqupdaterequest;

class FaqController extends Controller
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
                $items =  Faq::select(['id', 'faq','created_at', 'status']);
               

                 if($request->filled('date_from'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
                if($request->filled('date_to'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));


                return datatables()::of($items)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $edit =  route('faq.edit',encrypt($row->id));
                            $delete=route('faq.destroy',encrypt($row->id));
                            $btn = '<a href='."{$edit}".' class="edit btn btn-primary btn-sm editNews">Edit</a>
                             <a href="javascript:void(0)" data-id='.$row->id.' class="delete btn btn-danger btn-sm deletefaq">Delete</a>'; 
                            return $btn;
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
          
            return view('faq.index');
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
          return view('faq.create');
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
    public function store(faqstorerequest $request)
    { 
        try
        {
            
        $requestdata=$request->all();
        Faq::create($requestdata); 
        return redirect('faq')->with('success','Faq Added Successfully'); 
      }
     catch(\Exception $e) {
      
            // return $e->getMessage();
        return redirect('faq')->with('error','Faq create Failed'); 
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
        $id     = decrypt($id);
        $faq=Faq::findOrFail($id);
        return view('faq.edit',compact('faq'));    
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
    public function update(faqupdaterequest $request, $id)
    {
         try
        {
            $id     = decrypt($id);
        $requestdata=$request->all();
        

        $faq= Faq::find($id);
        $faq->update($requestdata); 
        return redirect('faq')->with('success','Faq updated Successfully'); 
      }
         catch(\Exception $e) {
         return redirect('faq')->with('error','Faq update Failed'); 
            // return $e->getMessage();
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
            $obj = Faq::destroy($id);

           
            
            return response()->json(['status'=>'true']);
        }catch(\Exception $e) {
          
             return response()->json(['status'=>'false']);
        } 
    }
}
