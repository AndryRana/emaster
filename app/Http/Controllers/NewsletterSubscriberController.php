<?php

namespace App\Http\Controllers;

use App\Exports\subscribersExport;
use App\NewsletterSubscriber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterSubscriberController extends Controller
{
    public function checkSubscriber(Request $request){
    	if($request->ajax()){
    		$data = $request->all();
    		/*echo "<pre>"; print_r($data); die;*/
    		$subscriberCount = NewsletterSubscriber::where('email',$data['subscriber_email'])->count();
    		if($subscriberCount>0){
    			echo "exists";
    		}
    	}
    }


    public function addSubscriber(Request $request){
    	if($request->ajax()){
    		$data = $request->all();
    		/*echo "<pre>"; print_r($data); die;*/
    		$subscriberCount = NewsletterSubscriber::where('email',$data['subscriber_email'])->count();
    		if($subscriberCount>0){
    			echo "exists";
    		}else{
                // Add Newsletter Email in newsletter_subscribers table
                $newsletter = new NewsletterSubscriber;
                $newsletter->email = $data['subscriber_email'];
                $newsletter->status = 1;
                $newsletter->save();
                echo "saved";
            }
        }
        
    }
    
    
    public function viewNewsletterSubscribers()
    {
        $newsletters = NewsletterSubscriber::get();
        return view('admin.newsletters.view_newsletters')->with(compact('newsletters'));
    }


    public function updateNewsletterStatus($id,$status)
    {
        NewsletterSubscriber::where('id',$id)->update(['status'=>$status]);
        return redirect()->back()->with('flash_message_success','Le statut du Newsletter a été mise à jour avec succès');
    }


    public function deleteNewsletterEmail($id)
    {
        NewsletterSubscriber::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','L\'email du Newsletter a été supprimé avec succès');
    }

    public function exportNewsletterEmails()
    {
        return Excel::download(new subscribersExport, 'subscribers.xlsx');
    }
}
