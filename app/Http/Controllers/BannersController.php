<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannersController extends Controller
{
    public function addBanner(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            $banner = new Banner;
            $banner->title = $data['banner_title'];
            $banner->link = $data['banner_link'];

            // Upload Image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $banner_path = 'images/frontend_images/banners/' . $fileName;
                    // Resize Image code
                    Image::make($image_tmp)->resize(1140, 441)->save($banner_path);

                    //  Store image name in banners table
                    $banner->image = $fileName;
                }
            }

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            $banner->status = $status;

            $banner->save();
            return redirect()->back()->with('flash_message_success', 'La bannière a été ajoutée avec succès!');
            // return redirect('/admin/view-banners')->with('flash_message_success', 'La bannière a été ajoutée avec succès!');
        }
        return view('admin.banners.add_banner');
    }
}
 