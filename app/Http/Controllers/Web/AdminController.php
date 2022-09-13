<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Mail\sendPasswordResetEmail;
use App\Http\Requests\AdminCreateUpdateRequest;
use App\Http\Requests\AdminChangePasswordRequest;

use App\Models\Role;
use App\Models\User;
use App\Models\CountryMaster;

use Carbon\Carbon;

class AdminController extends Controller
{
    private $model, $roles;

    public function __construct()
    {
        $this->model = new User;
        $this->roles = new Role;
    }

    public function index(AdminCreateUpdateRequest $request)
    {
        if ($request->ajax()) {
            $items = $this->model->admin()
                ->select(['id', 'name', 'created_at', 'role_id', 'email', 'is_active'])
                ->where('id', '!=', Auth::id());
            if ($request->filled('date_from'))
                $items = $items->whereDate('created_at', '>=', filterDate($request->date_from));
            if ($request->filled('date_to'))
                $items = $items->whereDate('created_at', '<=', filterDate($request->date_to));


            return Datatables::of($items)
                ->addIndexColumn()

                ->editColumn('created_at', function ($row) {
                    return displayDate($row->created_at);
                })
                ->addColumn('role_id', function ($row) {
                    return $row->roles->name;
                })
                ->make(true);
        }

        return view('admin.index');
    }

    public function create(AdminCreateUpdateRequest $request)
    {
        $roles = $this->roles->all();
        return view('admin.create', compact('roles'));
    }

    public function edit(AdminCreateUpdateRequest $request, $id)
    {
        $item = $this->model->admin()->with('countries')->findOrFail($id);
        $roles = $this->roles->all();

        return view('admin.edit', compact('item', 'roles'));
    }

    public function store(AdminCreateUpdateRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['selected_country_id'] = $data['countries'][0];
        $data['role_id'] = 2;
        $me = $this;
        $user = $me->model->create($data);
        $user->countries()->attach($data['countries']);

        DB::table('password_resets')->insert([
            'email' => $data['email'],
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        $token = DB::table('password_resets')
            ->where('email', $data['email'])
            ->first();

        try {
            Mail::to($data['email'])->send(new sendPasswordResetEmail($user, $token));
        } catch (\Exception $e) {
            Log::error($e);
        }

        if (count(Mail::failures()) > 0) {
            return false;
        }

        DB::commit();

        return redirect()->route('admin.index')->withSuccess(trans('common.admin.create_success'));
    }

    public function update(AdminCreateUpdateRequest $request, $id)
    {
        $item = $this->model->admin()->findOrFail($id);
        $data = $request->validated();

        if (!empty($data['password']))
            $data['password'] = Hash::make($data['password']);
        else
            unset($data['password']);

        $data['selected_country_id'] = $data['countries'][0];

        DB::transaction(function () use ($item, $data) {
            $item->update($data);
            $item->countries()->detach();
            $item->countries()->attach($data['countries']);
        });

        return redirect()->route('admin.index')->withSuccess(trans('common.admin.create_success'));
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $obj = $this->model->findOrFail($id);
            $obj->countries()->detach();
            $obj->delete();

            DB::commit();

            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'false']);
        }
    }

    public function changePassword()
    {
        return view('change_password');
    }

    public function updateChangePassword(AdminChangePasswordRequest $request)
    {
        $item = $this->model->admin()->findOrFail(Auth::id());
        $data = $request->validated();
        $hasedPassword = $item->password;

        if (Hash::check($data['old_password'], $hasedPassword)) {
            $data['password'] = Hash::make($data['password']);

            DB::transaction(function () use ($item, $data) {
                $item->update(['password' => $data['password']]);
            });

            Auth::logout();

            return redirect()->route('auth.logout')->with('success', trans('common.admin.change_password_success'));
        } else {
            return redirect()->back()->with('error', trans('common.admin.change_password_error'));
        }
    }

    public function changeLanguage(Request $request)
    {
        $country = CountryMaster::find($request->country_id);
        auth()->user()->update(['selected_country_id' => $country->id]);
        App::setLocale($country->language);
        date_default_timezone_set($country->time_zone);
        return redirect()->back();
    }
}
