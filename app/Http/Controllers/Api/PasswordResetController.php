<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\SmsServices;
use App\Mail\EmailManager;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Mail;

class PasswordResetController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone',
            'phone' => 'required_without:email',
        ]);

        if($request->email){
            $user = User::where('email', $request->email)->first();
        }
        elseif($request->phone){
            $user = User::where('phone', $request->phone)->first();
        }
        else{
            $user = null;
        }
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => translate('No user found with this information.')
            ], 200);
        }

        $user->verification_code = rand(100000,999999);
        $user->save();

        if($request->email){

            $array['view'] = 'emails.verification';
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['subject'] = translate('Password Reset');
            $array['content'] = translate('Password reset code is').': '.$user->verification_code;
    
            Mail::to($user->email)->queue(new EmailManager($array));

            return response()->json([
                'success' => true,
                'email' => true,
                'message' => translate('A password reset code has been sent to your email.')
            ], 200);

        }else{

            (new SmsServices)->forgotPasswordSms($user->phone, $user->verification_code);
            return response()->json([
                'success' => true,
                'phone' => true,
                'message' => translate('A password reset code has been sent to your phone number.')
            ], 200);
        }
    }

    public function reset(Request $request){
        $request->validate([
            'email' => 'required_without:phone',
            'phone' => 'required_without:email',
            'code' => 'required',
            'password' => 'required',
        ]);

        if($request->email){
            $user = User::where('email', $request->email)->first();
        }
        elseif($request->phone){
            $user = User::where('phone', $request->phone)->first();
        }
        else{
            $user = null;
        }
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => translate('No user found with this information.')
            ], 200);
        }

        if($user->verification_code != $request->code){
            return response()->json([
                'success' => false,
                'message' => translate('Code does not match.')
            ], 200);
        }else{

            if($request->password){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => translate('Your password has been updated.')
            ], 200);
        }
    }
}
