<?php

    namespace Sndpbag\Blog\Http\Controllers\Frontend;

    use Sndpbag\Blog\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Sndpbag\Blog\Models\Subscriber;
    use Sndpbag\Blog\Mail\VerifySubscriptionEmail;
    use Sndpbag\AdminPanel\Models\User;

    class NewsletterController extends Controller
    {
        public function subscribe(Request $request)
        {
            // ১. ভ্যালিডেশন
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        $query = Subscriber::where('email', $value);
                        if (Auth::check()) {
                            if (Subscriber::where('user_id', Auth::id())->exists()) {
                                $fail('আপনি ইতিমধ্যে সাবস্ক্রাইব করেছেন।');
                                return;
                            }
                            if ($query->whereNull('user_id')->exists()) {
                                $fail('এই ইমেইল অ্যাড্রেসটি অন্য কেউ ব্যবহার করছেন।');
                                return;
                            }
                        } else {
                            if ($query->whereNull('user_id')->exists()) {
                                $fail('এই ইমেইল অ্যাড্রেসটি ইতিমধ্যে সাবস্ক্রাইব করা আছে।');
                                return;
                            }
                        }
                    },
                ],
            ], [
                'email.required' => 'ইমেইল অ্যাড্রেস দিতেই হবে।',
                'email.email' => 'সঠিক ইমেইল অ্যাড্রেস দিন।',
            ]);

            if ($validator->fails()) {
                // *** পরিবর্তন: 422 JSON Error Response ***
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422); // 422 means Unprocessable Entity
            }

            // ২. টোকেন তৈরি এবং ডাটাবেসে সেভ
            try {
                $subscriber = Subscriber::create([
                    'email' => $request->input('email'),
                    'user_id' => Auth::id(),
                    'verification_token' => Str::random(60),
                ]);

                // ৩. ভেরিফিকেশন ইমেইল পাঠানো
                Mail::to($subscriber->email)->send(new VerifySubscriptionEmail($subscriber));

                // *** পরিবর্তন: 200 JSON Success Response ***
                return response()->json([
                    'message' => 'প্রায় হয়ে গেছে! আপনার ইমেইল (' . $subscriber->email . ') চেক করে সাবস্ক্রিপশন ভেরিফাই করুন।'
                ], 200); // 200 means OK

            } catch (\Exception $e) {
                // Duplicate entry ba onnano error handle
                if (Str::contains($e->getMessage(), 'Duplicate entry')) {
                    return response()->json([
                        'message' => 'এই ইমেইল অ্যাড্রেসটি ইতিমধ্যে সাবস্ক্রাইব করা আছে।',
                        'errors' => ['email' => ['এই ইমেইল অ্যাড্রেসটি ইতিমধ্যে সাবস্ক্রাইব করা আছে।']]
                    ], 422); // 422 for logical error
                }
                
                Log::error('Newsletter Subscription Error: '.$e->getMessage());
                
                // *** পরিবর্তন: 500 JSON Server Error Response ***
                return response()->json([
                    'message' => 'সাবস্ক্রিপশন করার সময় একটি সার্ভার সমস্যা হয়েছে।'
                ], 500); // 500 means Internal Server Error
            }
        }

        // ... verify method ...
        public function verify(Request $request, $token)
        {
            $subscriber = Subscriber::where('verification_token', $token)
                                    ->whereNull('email_verified_at')
                                    ->first();

            if (!$subscriber) {
                return redirect()->route('frontend.blog.index') // Blog index-e redirect
                           ->with('error', 'ভেরিফিকেশন লিঙ্কটি সঠিক নয় বা ব্যবহৃত হয়েছে।');
            }

            try {
                $subscriber->email_verified_at = now();
                $subscriber->subscribed_at = now();
                $subscriber->verification_token = null;
                $subscriber->save();

                return redirect()->route('frontend.blog.index') // Blog index-e redirect
                           ->with('success', 'ইমেইল সফলভাবে ভেরিফাই হয়েছে! ধন্যবাদ।');

            } catch (\Exception $e) {
                 Log::error('Newsletter Verification Error: '.$e->getMessage());
                return redirect()->route('frontend.blog.index') // Blog index-e redirect
                           ->with('error', 'ইমেইল ভেরিফাই করার সময় একটি সমস্যা হয়েছে।');
            }
        }
    }
 