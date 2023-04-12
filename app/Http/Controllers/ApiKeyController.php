<?php

namespace App\Http\Controllers;

use App\Services\MailerLite\MailerLiteApi;

class ApiKeyController extends Controller
{
    public function create()
    {
        return view('apikeys.create-edit');
    }

    public function store()
    {
        $response = MailerLiteApi::storeApiKey(
            request()->validate([
                'key' => 'required',
            ]),
        );

        if ($response['state'] === MailerLiteApi::SUCCESS) {
            return redirect('/');
        }

        return back()
            ->with('message', $response['message'])
            ->with('state', $response['state'])
            ->withInput();
    }
}