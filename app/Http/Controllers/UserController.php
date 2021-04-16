<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Role;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $users = User::orderBy('role_id', 'ASC')->paginate(10);

        $helper = new Helper;
        $amount_of_users = $helper->count_all_users();
        $amount_of_administrators = $helper->count_all_administrators();

        return view('dashboard.users.index', compact('users', 'amount_of_users', 'amount_of_administrators'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|Response|View
     */
    public function show($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('dashboard.users.details', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'permission' => 'required'
        ]);

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->permission;

        $user->save();

        return redirect('/dashboard/users')->with('message', 'User is geupdated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/dashboard/users')->with('message', 'User is removed!');
    }
}
