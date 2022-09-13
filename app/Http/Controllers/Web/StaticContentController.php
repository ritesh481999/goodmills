<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\faqstorerequest;
use App\Http\Requests\staticContent\StaticContentCreateRequest;
use App\Models\FAQ;
use App\Models\Farmer;
use App\Models\StaticContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaticContentController extends Controller
{
    const VIEW_DIR = "static_content.";

    public function index()
    {
        $contents = static_content_type();
        return view(self::VIEW_DIR . 'index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticContentCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $data['content_type'] = $request->content_type;
            $data['country_id'] = Auth::user()->selected_country_id;
            StaticContent::create($data);
            DB::commit();
            return redirect()->route('static_contents.index')->with('success', trans('common.static_contents.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('static_contents.index')->with('error',trans('common.static_contents.error'));
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
    public function edit($slug)
    {
        try {
            $key = array_search($slug, array_column(static_content_type(), 'slug'));
            $data['content_type'] = $key;
            $static_content = null;
            if ($data['content_type'] == 0) {
                $data['content_type'] = "FAQs";
                $data['contents'] = FAQ::whereCountry_id(Auth::user()->selected_country_id)->get();
                $view = 'faqs.edit';
            } else {
                $data['content'] = StaticContent::whereCountry_id(Auth::user()->selected_country_id)->whereContent_type($data['content_type'])->first();
                $view = 'edit';
            }
            return view(self::VIEW_DIR . $view, $data);
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
    public function update(StaticContentCreateRequest $request, StaticContent $static_content)
    {

        DB::beginTransaction();
        try {
            $data = $request->validated();
            $static_content->update($data);
            DB::commit();
            return redirect()->route('static_contents.index')->with('success', trans('common.static_contents.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('static_contents.index')->with('error', trans('common.static_contents.error'));
        }
    }

    public function storeFaqs(faqstorerequest $request)
    {

        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request->faqs_ids) {
                $faqs_ids = explode(',', $request->faqs_ids);
                $db_faqs_contents = FAQ::whereCountry_id(Auth::user()->selected_country_id)->pluck('id')->toArray();
                $deletedIds = array_diff($db_faqs_contents, $faqs_ids);
                if ($deletedIds) {
                    FAQ::whereIn('id', $deletedIds)->delete();
                }
                FAQ::whereIn('id', $faqs_ids)->delete();

                for ($count = 0; $count < count($data['question']); $count++) {
                    $item['country_id'] = Auth::user()->selected_country_id;
                    $item['question'] = $data['question'][$count];
                    $item['answer'] = $data['answer'][$count];
                    FAQ::create($item);
                }
            } else {
                for ($count = 0; $count < count($data['question']); $count++) {
                    $item['country_id'] = Auth::user()->selected_country_id;
                    $item['question'] = $data['question'][$count];
                    $item['answer'] = $data['answer'][$count];
                    FAQ::create($item);
                }
            }

            DB::commit();

            return redirect()->route('static_contents.index')->with('success', trans('common.static_contents.success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('static_contents.index')->with('error', trans('common.static_contents.error'));
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
        if($id == 1)
        {
            FAQ::whereCountry_id(Auth::user()->selected_country_id)->delete();
        }
        else
        {
            StaticContent::whereCountry_id(Auth::user()->selected_country_id)->delete();
        }

        return response()->json(['status' => 'true']);
    }
}
