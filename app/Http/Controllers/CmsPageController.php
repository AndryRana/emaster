<?php

namespace App\Http\Controllers;

use App\Category;
use App\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CmsPageController extends Controller
{

    public function addCmsPage(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            $cmspage = new CmsPage;
            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            $cmspage->status = $status;
            $cmspage->save();
            return redirect()->back()->with('flash_message_success', 'CMS Page a été créé avec succès');
        }
        return view('admin.pages.add_cms_page');
    }


    public function editCmsPage(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            CmsPage::where('id', $id)->update(['title' => $data['title'], 'url' => $data['url'], 'description' => $data['description'], 'status' => $status]);
            return redirect()->back()->with('flash_message_success', 'CMS Page a été mise à jour avec succès');
        }
        $cmsPage = CmsPage::where('id', $id)->first();
        // echo "<pre>";print_r($cmsPage);die;
        return  view('admin.pages.edit_cms_page')->with(compact('cmsPage'));
    }



    public function viewCmsPages()
    {
        $cmsPages = CmsPage::get();
        // $cmsPages = json_decode(json_encode($cmsPages));
        // echo "<pre>";print_r($cmsPages);die;

        return view('admin.pages.view_cms_pages')->with(compact('cmsPages'));
    }


    public function deleteCmsPage($id)
    {
        CmsPage::where('id', $id)->delete();
        return redirect('/admin/view-cms-pages')->with('flash_message_success', 'CMS Page a été supprimé avec succès');
    }


    public function cmsPage($url)
    {
        // Redirect to 404 if CMS Page is disabled or does'nt exists
        $cmsPageCount = CmsPage::where(['url' => $url, 'status' => 1])->count();
        if ($cmsPageCount > 0) {
            // Get CMS page Details
            $cmsPageDetails = CmsPage::where('url', $url)->first();
        } else {
            abort(404);
        }


        //  Get all Categories and Sub Categories
        $categories =  Category::with('categories')->where(['parent_id' => 0])->get();
        return view('pages.cms_page')->with(compact('cmsPageDetails', 'categories'));
    }



    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email',
                'subject' => 'required',
            ]);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // Send Contact Email
            $email = "aranarison@gmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message']
            ];

            Mail::send('email.enquiry', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Demande d\'information sur Emaster');
            });

            return redirect()->back()->with('flash_message_success', 'Merci pour votre demande. Nous reviendrons vers vous bientôt.');
            // echo "test"; die;
        }
        //  Get all Categories and Sub Categories
        $categories =  Category::with('categories')->where(['parent_id' => 0])->get();
        return view('pages.contact')->with(compact('categories'));
    }
}
