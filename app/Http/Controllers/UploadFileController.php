<?php

namespace App\Http\Controllers;

use App\Avatar;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function fileUpload(Request $request){

        if($request->isMethod('post')){

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $old_file=auth()->user()->avatars()->first();
                auth()->user()->avatars()->detach();
                $old_file_path=$old_file->path;
                $old_file->delete();
                $name=(md5(rand(0, 99999999999).auth()->user()->id)).'.jpg';
                $file->move(public_path() . '/img/profiles_images/',$name);
                $avatar=new Avatar();
                $avatar->path = '/img/profiles_images/'.$name;
                $avatar->save();
                auth()->user()
                    ->avatars()
                    ->attach($avatar);
                if (file_exists(public_path().$old_file_path)) {
                    unlink(public_path().$old_file_path);
                } else {
                    // File not found.
                }
            }
        }
        return redirect('/profile');
    }
}
