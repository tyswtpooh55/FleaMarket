<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/index');
    }

    public function getUsers()
    {
        $users = User::withoutRole('admin')
            ->with('items', 'transactions')
            ->paginate(10);

        return view('admin/user_management', compact(
            'users',
        ));
    }

    public function deleteUser($user_id)
    {
        User::find($user_id)->delete();

        return back();
    }

    public function writeEmail()
    {
        return view('admin/email');
    }

    public function sendEmail(EmailRequest $request)
    {
        $recipients = explode(',', $request->input('recipients', ''));
        dd($recipients);
        $subject = $request->input('subject');
        $message = $request->input('message');

        $customers = User::whereIn('id', $recipients)->get();

        foreach ($customers as $customer) {
            Mail::raw($message, function ($msg) use ($customer, $subject) {
                $msg->to($customer->email)->subject($subject);
            });
        }

        return redirect()->back()->with('success', 'メールを送信しました');
    }
}
