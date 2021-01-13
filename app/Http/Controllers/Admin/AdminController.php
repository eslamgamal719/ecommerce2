<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\AdminDatatable;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Admin;
use App\Http\Requests\Dashboard\EditAdminRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDatatable $admin)
    {
        return $admin->render('dashboard.admins.index', ['title' => 'Admin Control']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admins.create', ['title' => __('admin.create_admin')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $data = $request->except('password');
        $data['password'] = bcrypt($request->password);

        Admin::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('admin'));
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
        $admin = Admin::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.admins.edit', compact('admin', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAdminRequest $request, $id)
    {
        if($request->has('password')) {
            $data = $request->except('password');
            $data['password'] = bcrypt($request->password);
        }

        $admin = Admin::findOrFail($id);
        $admin->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('admin'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('admin'));
    }


    public function multi_delete() {

        if(is_array(request('item'))) {
            Admin::destroy(request('item'));
        }else {
            Admin::find(request('item'))->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('admin'));
    }
}
