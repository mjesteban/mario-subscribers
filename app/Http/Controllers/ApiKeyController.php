<?php

namespace App\Http\Controllers;

use App\Services\MailerLite\MailerLiteApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ApiKeyController extends Controller
{
    public function create()
    {
        try {
            DB::table('api_keys')
                ->select('key')
                ->value('key');
        } catch (\Exception $e) {
            abort(Response::HTTP_SERVICE_UNAVAILABLE, $e->getMessage());
        }

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