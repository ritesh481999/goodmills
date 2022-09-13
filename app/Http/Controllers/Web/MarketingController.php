<?php

namespace App\Http\Controllers\Web;

use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Marketing\MarketingCreateRequest;
use App\Http\Traits\SMSTrait;
use App\Models\CountryMaster;
use App\Models\Farmer;
use App\Models\MarketingFile;
use App\Http\Traits\NotificationTrait;

class MarketingController extends Controller
{
    use SMSTrait;
    use NotificationTrait;
    const VIEW_DIR = "marketing.";
    private $marketing;

    public function __construct(Marketing $marketing)
    {
        $this->marketing = $marketing;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            DB::enableQueryLog();
            if ($request->ajax()) {
                $items = $this->marketing->select(['id', 'title', 'short_description', 'created_at', 'status', 'country_id'])->with('country:id,name')->orderBy('id', 'desc');
                if ($request->filled('from_date'))
                    $items = $items->whereDate('created_at', '>=', filterDate($request->from_date));
                if ($request->filled('to_date'))
                    $items = $items->whereDate('created_at', '<=', filterDate($request->to_date));
                if ($request->filled('country_id'))
                    $items = $items->where('country_id', $request->country_id);
                return datatables()::of($items)
                    ->addIndexColumn()
                    ->addColumn('action', '&nbsp;')
                    ->editColumn('action', function ($row) {
                        $routeKey = 'marketing';
                        return view('template.action', compact('routeKey', 'row'))->render();
                    })
                    ->editColumn('created_at', function ($row) {
                        return displayDate($row->created_at);
                    })
                    ->editColumn('country_id', function ($row) {
                        return $row->country->name;
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
            $countries = CountryMaster::pluck('name', 'id')->toArray();
            return view(self::VIEW_DIR . 'index', compact('countries'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return view(self::VIEW_DIR . 'create');
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
    public function store(MarketingCreateRequest $request)
    {

        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image'] = fileUpload($data['image'], 'marketing/image');
            }
            $data['country_id'] = auth()->user()->selected_country_id;
            $marketing = $this->marketing->create($data);

            $marketing_files = $request->file('marketing_files');
            // dd($image4);
            if (!empty($marketing_files)) {
                foreach ($marketing_files as $marketing_file) {
                    $data['file_name'] = $marketing_file;
                    $data['file_name'] = fileUpload($data['file_name'], 'marketing/files');
                    $data['marketing_id'] = $marketing->id;
                    $data['file_mime_type'] = $marketing_file->getClientMimeType();
                    $marketing->marketing_files()->create($data);
                }
            }

            //Push Notification
            if ($marketing) {
                if ($marketing->is_notification == 1 && $marketing->status == 1) {

                    $notification_data = [
                        'item_id' => $marketing->id,
                        'title' => $marketing->title,
                        'description' =>  $marketing->description,
                        'item_type' => 2,
                        'type' => 1,
                        'device_type' => 1,
                        'ip_address' => \Request::ip(),
                        'country_id' => $data['country_id']
                    ];
                    $this->createNotification($notification_data, 'is_marketing_notification', 1, auth()->user());
                }

                if ($marketing->is_sms == 1 && $marketing->status == 1) {
                    $farmer = new Farmer();
                    $farmers = $farmer->getFarmersPhoneNumber('is_marketing_sms');
                    if (count($farmers) > 0) {
                        foreach ($farmers as  $farmer) {
                            $message = trans('messages.sms_text', ['name' => $farmer['full_name'], 'app_name' => config('app.name'), 'title' => $marketing->title]);

                            $this->sendSMS($message, $farmer['phone_number']);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('marketing.index')->with('success', 'Marketing Detail Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('marketing.index')->with('error', 'Marketing Creation Failed');
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
    public function edit(Marketing $marketing)
    {
        try {
            $files = [];
            foreach ($marketing->marketing_files as $key => $marketing_file) {
                $files[$key]['id'] = $marketing_file->id;
                $files[$key]['src'] = $marketing_file->file_name;
            }

            $files = json_encode($files);

            return view(self::VIEW_DIR . 'edit', compact('marketing', 'files'));
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
    public function update(MarketingCreateRequest $request, Marketing $marketing)
    {


        DB::beginTransaction();
        try {
            $data = $request->validated();
            if (isset($data['image']) && !empty($data['image'])) {
                !empty($marketing->image) && removeFile($marketing->image);
                $data['image'] = fileUpload($data['image'], 'marketing/image');
            }
            if (!empty($marketing->marketing_files) && $request->old_marketing_files) {
                $db_marketing_files = $marketing->marketing_files->pluck('id')->toArray();

                $deletedIds = array_diff($db_marketing_files, $data['old_marketing_files']);

                multipleFilesRemove($marketing->marketing_files()->whereIn('id', $deletedIds)->get());
                $marketing->marketing_files()->whereIn('id', $deletedIds)->delete();
            }
            if (isset($data['marketing_files']) && !empty($data['marketing_files'])) {
                $marketing_files = $request->file('marketing_files');

                foreach ($marketing_files as $marketing_file) {
                    $data['file_name'] = $marketing_file;
                    $data['file_name'] = fileUpload($data['file_name'], 'marketing/files');
                    $data['marketing_id'] = $marketing->id;
                    $data['file_mime_type'] = $marketing_file->getClientMimeType();
                    $marketing->marketing_files()->create($data);
                }
            }

            $marketing->update($data);
            //push notification

            DB::commit();
            return redirect()->route(self::VIEW_DIR . 'index')->with('success', 'Marketing Detail Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route(self::VIEW_DIR . 'index')->with('error', 'Marketing Updation Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marketing $marketing)
    {
        DB::beginTransaction();
        try {
            $marketing->marketing_files()->delete();
            $marketing->delete();

            DB::commit();

            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'false']);
        }
    }
}
