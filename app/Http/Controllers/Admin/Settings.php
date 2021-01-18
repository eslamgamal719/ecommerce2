<?php

namespace App\Http\Controllers\Admin;

use Up;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ImageRequest;


class Settings extends Controller
{

     public function settings() {
         return view('dashboard.settings', ['title' => __('admin.settings')]);
     }


     public function setting_save(ImageRequest $request) {
         $data = request()->except(['_token', '_method']);

         if(request()->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file'         => 'logo',
                'path'         => 'settings',
                'upload_type'  => 'single',
                'delete_file'  => setting()->logo
            ]);
         }

         if(request()->hasFile('icon')) {
             $data['icon'] = up()->upload([
                 'file'         => 'icon',
                 'path'         => 'settings',
                 'upload_type'  => 'single',
                 'delete_file'  => setting()->icon
             ]);
         }

         Setting::orderBy('id', 'DESC')->update($data);

         session()->flash('success',  __('admin.record_updated'));
         return redirect(aurl('settings'));
     }
}
