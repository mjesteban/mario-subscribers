<?php

namespace App\Http\Middleware;

use App\Services\MailerLite\MailerLiteApi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailerLiteAuth
{
    public function handle(Request $request, Closure $next)
    {
        $keyFromDb = DB::table('api_keys')
            ->select('key')
            ->value('key');

        if (empty($keyFromDb)) {
            return redirect()
                ->route('api-keys.create')
                ->with('state', MailerLiteApi::FAILED)
                ->with('message', 'Restricted. Enter a MailerLite API Key.');
        }

        return $next($request);
    }
}