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

    
    public function editBanners(Request $request, $id = null)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }


            if(empty($data['title'])){
                $data['title'] = '';
            }

            if(empty($data['title'])){
                $data['title'] = '';
            }
               // Upload Image
               if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $banner_path = 'images/frontend_images/banners/' . $fileName;
                    // Resize Image code
                    Image::make($image_tmp)->resize(1140, 441)->save($banner_path);

                }
 
            }else if (!empty($data['current_image'])) {
                $fileName = $data['current_image'];
            } else {
                $filename = '';
            }

            Banner::where(['id'=>$id])->update([
                'image'=>$fileName, 'title'=>$data['banner_title'], 'link'=>$data['banner_link'], 'status'=>$status
            ]);
            
            return redirect()->back()->with('flash_message_success', 'La bannière a été modifiée avec succès');

        }
        $bannerDetails = Banner::where('id',$id)->first();

        return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
    }

    
    
    public function viewBanners()
    {
        $banners = Banner::get();
        return view('admin.banners.view_banners')->with(compact('banners'));
    }
    


    public function deleteBanner($id = null)
    {
        Banner::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'La bannière a été supprimée avec succès!');
    }
}
 