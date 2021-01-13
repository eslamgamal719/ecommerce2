<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\UserDatatable;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Http\Requests\Dashboard\EditUserRequest;
use App\Http\Requests\Dashboard\UserRequest;
use App\User;
use App\Http\Requests\Dashboard\EditAdminRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDatatable $user)
    {
        return $user->render('dashboard.users.index', ['title' => __('admin.users')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->except('password');
        $data['password'] = bcrypt($request->password);

        User::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('users'));
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
        $user = User::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.users.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        if($request->has('password')) {
            $data = $request->except('password');
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('users'));
    }


    public function multi_delete() {

        if(is_array(request('item'))) {
            User::destroy(request('item'));
        }else {
            User::find(request('item'))->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('users'));
    }
}
