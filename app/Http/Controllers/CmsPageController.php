<?php

namespace App\Http\Controllers;

use App\CmsPage;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class CmsPageController extends Controller
{

    public function addCmsPage(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            $cmspage = new CmsPage;
            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            if(empty($data['status'])){
    			$status = 0;
    		}else{
    			$status = 1;
            }
            $cmspage->status = $status;
            $cmspage->save();
            return redirect()->back()->with('flash_message_success','CMS Page a été créé avec succès');

        }
        return view('admin.pages.add_cms_page');
    }


    public function viewCmsPages()
    {
        $cmsPages = CmsPage::get();
        // $cmsPages = json_decode(json_encode($cmsPages));
        // echo "<pre>";print_r($cmsPages);die;

        return view('admin.pages.view_cms_pages')->with(compact('cmsPages'));
    }
}
