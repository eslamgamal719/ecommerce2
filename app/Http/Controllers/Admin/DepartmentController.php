<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CityDatatable;
use App\DataTables\CountryDatatable;
use App\Http\Controllers\Controller;
use App\DataTables\AdminDatatable;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Admin;
use App\Http\Requests\Dashboard\CityRequest;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Http\Requests\Dashboard\DepartmentRequest;
use App\Http\Requests\Dashboard\EditAdminRequest;
use App\Models\City;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.departments.index', ['title' => __('admin.departments')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.departments.create', ['title' => __('admin.create')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'departments',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        Department::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('departments'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.departments.edit', compact('department', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'departments',
                'upload_type' => 'single',
                'delete_file' => $department->icon
            ]);
        }

        $department->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('departments'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       self::delete_children($id);

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('departments'));
    }



    private static function delete_children($id) {

        $children = Department::whereParent($id)->get();
        foreach($children as $child) {

            self::delete_children($child->id);

            if(!empty($child->icon)) {
                Storage::has($child->icon) ? Storage::delete($child->icon) : '';
            }
            $child->delete();
        }
        $department = Department::find($id);
        Storage::has($department->icon) ? Storage::delete($department->icon) : '';
        $department->delete;
    }


}
