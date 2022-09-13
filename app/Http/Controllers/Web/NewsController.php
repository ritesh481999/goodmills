<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\NewsCreateRequest;
use App\Http\Traits\SMSTrait;
use App\Models\CountryMaster;
use App\Models\Farmer;
use App\Models\FarmerDevice;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\NotificationTrait;
use App\Models\Notification;
use App\Models\NotificationUser;

class NewsController extends Controller
{
    use SMSTrait;
    use NotificationTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = News::select(['id', 'title', 'country_id', 'short_description', 'created_at', 'status'])->with('country:id,name');
            if ($request->filled('from_date'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->from_date));
            if ($request->filled('to_date'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->to_date));
            if ($request->filled('country_id'))
                $items = $items->where('country_id', $request->country_id);




            return DataTables::of($items)
                ->addIndexColumn()
                ->addColumn('action', '&nbsp;')
                ->editColumn('action', function ($row) {
                    $routeKey = 'news';
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
        return view('news.index', compact('countries'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(NewsCreateRequest $request)
    {
        // DB::beginTransaction();
        // try {
        $data = $request->validated();
        if($request->hasFile('image')){
            $data['image'] = fileUpload($data['image'], 'news/image');
        }
      
        $data['country_id'] = auth()->user()->selected_country_id;
        $news = News::create($data);

        if ($news) {
            //Push Notification
            if ($news->is_notification == 1 && $news->status == 1) {
                $notification_data = [
                    'item_id' => $news->id,
                    'title' => $data['title'],
                   'description' => $data['short_description'],
                   'item_type' => 1,
                     'type' => 1,
                    'device_type' => 1,
                    'ip_address' => \Request::ip(),
                    'country_id' => $data['country_id']
                ];
                $this->createNotification($notification_data,'is_news_notification',1,auth()->user());
               
            }
            //SMS
            if (true == $news->is_sms && true == $news->status) {
                $farmer = new Farmer();
                $farmers = $farmer->getFarmersPhoneNumber('is_news_sms');
                if (count($farmers) > 0) {
                    foreach ($farmers as  $farmer) {
                        $message = trans('messages.sms_text', ['name' => $farmer['full_name'], 'app_name' => config('app.name'), 'title' => $news->title]);

                        $this->sendSMS($message, $farmer['phone_number']);
                    }
                }
            }
        }

        //DB::commit();
        return redirect()->route('news.index')->with('success', 'News Detail Created Successfully');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->route('news.index')->with('error', 'News Detail Failed');
        // }
    }

    public function edit(Request $request, News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(NewsCreateRequest $request, News $news)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if (isset($data['image']) && !empty($data['image'])) {
                !empty($news->image) && removeFile($news->image);
                $data['image'] = fileUpload($data['image'], 'news/image');
            }
            $news->update($data);

            DB::commit();
            return redirect()->route('news.index')->with('success', 'News Detail Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('news.index')->with('error', 'News Detail Updation Failed');
        }
    }

    public function destroy(News $news)
    {

        $news->delete();
        return response()->json(['status' => 'true']);
    }
}
