<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(ContactRequest $request): JsonResponse
    {
        $data = $request->validated();

        Mail::to(config('mail.from.address'))->send(new ContactMessageMail(
            $data['nom'],
            $data['email'],
            $data['message'],
        ));

        return response()->json(['message' => 'Message envoyé.']);
    }
}
