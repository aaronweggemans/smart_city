<?php

namespace App\Http\Controllers;

use App\Helper;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function settings()
    {
        $helper = new Helper;
        $cities = $helper->firebase;
        $streets = $helper->getAllStreetsWhere(Auth::user()->city_id);

        return view('dashboard.account.index', compact('cities', 'streets'));
    }

    /**
     * @return Application|Factory|View
     */
    public function profile_picture()
    {
        return view('dashboard.account.profile-image');
    }

    /**
     * Updates a image and changes it inside the database
     * Use "php artisan storage:link"
     *
     * Todo: Please change the name you give it
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function change_picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required'
        ]);

        try {
            $original_image = $request->file('profile_picture')->get();
            $image_name = $request->file('profile_picture')->getClientOriginalName();

            Storage::disk('profile_picture')->put($image_name, $original_image);
            $image_path = Storage::disk('profile_picture')->path($image_name);
            Image::make($image_path)->resize(250, 250)->save();

            $user = User::find(Auth::user()->id);

            $user->avatar = $image_name;

            $user->save();
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return redirect('/dashboard/settings')->with('message', 'You have changed your profile image!');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function change_location(Request $request)
    {
        $request->validate([
            'city' => 'required|integer',
            'street' => 'required|integer'
        ]);

        $user = User::find(Auth::user()->id);

        $user->city_id = $request->city;
        $user->street_id = $request->street;

        $user->save();

        return redirect('/dashboard/settings')->with('message', 'You updated your location!');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update_user(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user = User::find(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return redirect('/dashboard/settings')->with('message', 'You have changed your profile settings!');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function delete_user()
    {
        $user = User::find(Auth::user()->id);

        $user->delete();

        return redirect('/');
    }
}
