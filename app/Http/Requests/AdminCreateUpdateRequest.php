<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;
use App\Models\Role;

class AdminCreateUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->is_super_admin;
    }

    public function rules()
    {
        $route_name = $this->route()->getName();

        if (!in_array($route_name, ['admin.update', 'admin.store']))
            return [];

        $roles = Role::pluck('id')->toArray();
        

        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:' . (new User)->getTable() . ',email',
            'password' => 'required|string|min:6|max:12',
            'countries' => 'required|array',
            'is_active' => 'required|in:1,0'
        ];

        if ($route_name == 'admin.update') {
            $rules['email'] .= ',' . $this->route('id');
            $rules['password'] = str_replace('required', 'nullable', $rules['password']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('admin_error.name.required'),
            'name.string' => __('admin_error.name.string'),
            'name.max' => __('admin_error.name.max'),
            'email.required' => __('admin_error.email.required'),
            'email.email' => __('admin_error.email.email'),
            'email.unique' => __('admin_error.email.unique'),
            'password.required' => __('admin_error.password.required'),
            'password.string' => __('admin_error.password.string'),
            'password.min' => __('admin_error.password.min'),
            'password.max' => __('admin_error.password.max'),
            'countries.required' => __('admin_error.countries.required'),
            'countries.in' => __('admin_error.countries.array'),
            'is_active.required' => __('admin_error.is_active.required'),
            'is_active.in' => __('admin_error.is_active.in'),
        ];
    }
}
