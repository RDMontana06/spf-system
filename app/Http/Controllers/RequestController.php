<?php

namespace App\Http\Controllers;

use App\Bank;
use App\User;
use App\Project;
use App\FormRequest;
use App\FormRequestHistory;
use Illuminate\Http\Request;
use App\Notifications\ReviewNotif;
use App\Notifications\ApprovalNotif;
use App\Payment;
use App\RequestAttachment;

class RequestController extends Controller
{
    //

    public function requests()
    {
        $banks = Bank::get();
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company', 'user', 'bank_info', 'attachments')->where('encode_by', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $form_requests_pending = FormRequest::with('project.company', 'user', 'bank_info', 'attachments')->where('encode_by', auth()->user()->id)->where('status', 'Pending')->get();
<<<<<<< HEAD
        $form_requests_cancelled = FormRequest::with('project', 'user', 'bank_info', 'attachments', 'request_history')->where('encode_by', auth()->user()->id)->where('status', 'Cancelled')->get();
=======
        $form_requests_cancelled = FormRequest::with('project.company', 'user', 'bank_info', 'attachments', 'request_history')->where('encode_by', auth()->user()->id)->where('status', 'Cancelled')->get();
        
>>>>>>> b1ecdadd83ec7435dad9a78c7f27b3d1d27ac2b7
        $header = "Requests";
        $subheader = "";

        //   dd($form_requests_cancelled->all());

        return view(
            'requests',
            array(
                'header' => $header,
                'subheader' => $subheader,
                'banks' => $banks,
                'projects' => $projects,
                'form_requests' => $form_requests,
                'form_requests_pending' => $form_requests_pending,
                'form_requests_cancelled' => $form_requests_cancelled,
            )
        );
    }
    public function new_request(Request $request)
    {
        $reqApprover = User::where('role_id', '4')->orderBy('id', 'desc')->first();
        $pay_code = FormRequest::orderBy('id', 'desc')->first();
        if ($pay_code == "") {
            $code = 1;
        } else {
            $code = $pay_code->payee_code + 1;
        }
        $form = new FormRequest;
        $form->spf_type = $request->project;
        $form->purpose = $request->purpose;
        $form->project_id = $request->project_id;
        $form->name_of_payee = $request->payee;
        $form->bank = $request->bank;
        $form->account_number = $request->account_number;
        $form->amount = $request->amount;
        $form->amount_in_words = $request->amount_in_words;
        $form->payee_code = $code;
        $form->remarks = $request->remarks;
        $form->encode_by = auth()->user()->id;
        $form->approval_id = $reqApprover->id;
        $form->status = "Pending";
        $form->save();

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $path = $file->getClientOriginalName();
                $name = time() . '-' . $path;
                $attachment = new RequestAttachment();
                $file->move(public_path() . '/request-files/', $name);
                $file_name = '/request-files/' . $name;
                $attachment->attachment_url = $file_name;
                $attachment->form_request_id = $form->id;
                $attachment->save();
            }
        }

        $history = new FormRequestHistory;
        $history->form_request_id = $form->id;
        $history->action = "Create Request";
        $history->remarks = $request->remarks;
        $history->action_by = auth()->user()->id;
        $history->save();


        $userReviewer = User::where('id', $form->approval_id)->first();
        $requestor = User::where('id', $form->encode_by)->first();
        $userReviewer->notify(new ReviewNotif($form));

        $request->session()->flash('status', 'Successfully created');
        return back();
    }
    public function cancel_request($id)
    {
        FormRequest::Where('id', $id)->update(['status' => 'Cancelled']);

        $form = FormRequest::where('id', $id)->first();
        $history = new FormRequestHistory;
        $history->form_request_id = $form->id;
        $history->action = "Cancel Request";
        $history->remarks = "Request Cancelled";
        $history->action_by = auth()->user()->id;
        $history->save();

        return back();
    }
    public function for_review()
    {
        $banks = Bank::get();
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company', 'user', 'bank_info', 'attachments')->orderBy('created_at', 'DESC')->get();
        // $reviewed_requests = FormRequest::with('project.company', 'user', 'bank_info', 'attachments')->where('status', 'Reviewed')->where('approval_id', auth()->user()->id)->get();
        //  dd(auth()->user()->id);
        $header = "For Review";
        $subheader = "";

        return view(
            'for_reviews',
            array(
                'header' => $header,
                'subheader' => $subheader,
                'banks' => $banks,
                'projects' => $projects,
                'form_requests' => $form_requests,
                // 'reviewed_requests' => $reviewed_requests,
            )
        );
    }
    public function for_verification()
    {
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company', 'user', 'bank_info', 'attachments')->orderBy('created_at', 'DESC')->get();
        $form_requests_approved = FormRequest::with('project.company', 'user', 'bank_info', 'attachments', 'request_history')->where('approval_id', auth()->user()->id)->where('status', 'Approved')->get();
        $header = "For Verification";
        // dd($form_requests_approved->all());
        $subheader = "";

        return view(
            'for_verification',
            array(
                'header' => $header,
                'subheader' => $subheader,
                'projects' => $projects,
                'form_requests' => $form_requests,
                'form_requests_approved' => $form_requests_approved,

            )
        );
    }
    public function reviewed_request(Request $request, $id)
    {
        // dd($request);
        $reqApprover = User::where('role_id', '5')->orderBy('id', 'desc')->first();
        // dd($reqApprover);
        $form = FormRequest::where('id', $id)->first();
        $form->status = "Reviewed";
        $form->remarks = $request->remarks;
        $form->approval_id = auth()->user()->id;
        $form->save();

        $history = new FormRequestHistory;
        $history->form_request_id = $id;
        $history->action = "Reviewed Request";
        $history->remarks = $request->remarks;
        $history->action_by = auth()->user()->id;
        $history->save();

        $userLvl2Approver = User::where('id', $form->approval_id)->first();
        // dd($form);
        $userLvl2Approver->notify(new ApprovalNotif($form));

        $request->session()->flash('status', 'Successfully Reviewed');
        return back();
    }
    public function for_payment()
    {
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company', 'user', 'bank_info', 'attachments')->where('status', 'Approved')->get();
        $header = "For Payment";
        $subheader = "";
        $payments = Payment::all();

        return view(
            'for_payment',
            array(
                'header' => $header,
                'subheader' => $subheader,
                'projects' => $projects,
                'form_requests' => $form_requests,
                'payments' =>  $payments,
            )
        );
    }
    public function save_payment(Request $request, $id)
    {
        // dd($id);
        $this->validate($request, [
            'voucher_number' => 'required',
            'voucher_amount' => 'required',
            'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);
        $file      = $request['attachment']; // get the validated file
        $extension = $file->getClientOriginalExtension();
        $filename  = 'payment-' . time() . '.' . $extension;
        $path      = $file->storeAs('payments_attachment', $filename);

        $payment = new Payment;
        $payment->voucher_number = $request->voucher_number;
        $payment->voucher_amount = $request->voucher_amount;
        $payment->request_id = $id;
        $payment->attachment = $path;
        $payment->encoded_by = auth()->user()->id;
        $payment->save();

        $request->session()->flash('status', 'Successfully Store');
        return back();
    }
    public function approved_request(Request $request, $id)
    {
        $form = FormRequest::where('id', $id)->first();
        $form->status = "Approved";
        $form->remarks = $request->remarks;
        $form->approval_id = auth()->user()->id;
        $form->save();

        $history = new FormRequestHistory;
        $history->form_request_id = $id;
        $history->action = "Approved Request";
        $history->remarks = $request->remarks;
        $history->action_by = auth()->user()->id;
        $history->save();
        $request->session()->flash('status', 'Successfully Approved');
        return back();
    }
}
