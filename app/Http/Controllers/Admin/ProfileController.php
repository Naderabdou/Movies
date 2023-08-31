<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordRequest;
use App\Http\Requests\Admin\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit');
    }// end of edit

    public function update(ProfileRequest $request)
    {

        $requestData = $request->except(['_token', '_method']);

        if ($request->image) {
            Storage::disk('local')->delete('public/uploads/' . auth()->user()->image);
            $request->image->store('public/uploads');
            $requestData['image'] = $request->image->hashName();
        }

        auth()->user()->update($requestData);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->back();
    }// end of update

    //password routes
    public function editPassword()
    {
        return view('admin.profile.password.edit');
    }// end of editPassword4

    public function updatePassword(ProfilePasswordRequest $request)
    {

        auth()->user()->update(['password' => $request->password]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->back();
    }// end of updatePassword
}
