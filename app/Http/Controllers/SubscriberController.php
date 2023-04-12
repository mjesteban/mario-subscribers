<?php

namespace App\Http\Controllers;

use App\Services\MailerLite\MailerLiteApi;

class SubscriberController extends Controller
{
    public function index()
    {
        return view('subscribers.index');
    }

    public function create()
    {
        return view('subscribers.create');
    }

    public function getSubscribers(MailerLiteApi $mailerLite)
    {
        $total = $mailerLite->getTotalSubscribers();

        $search = request('search.value');
        $limit = !empty($search) ? $total : (int) request('length', 10);
        //get request,
        $response = $mailerLite->getSubscribers($limit, $search);

        $response['draw'] = (int) request('draw');
        $response['recordsTotal'] = $total;
        $response['recordsFiltered'] = $response['meta']['per_page'];

        return $response;
    }

    public function store(MailerLiteApi $mailerLite)
    {
        $response = $mailerLite->storeSubscriber(
            request()->validate([
                // normally I'd set email | required,
                // but as part of the requirement, validation is through the API.
                'email' => 'max:1024',
                'name' => 'max:1024',
                'last_name' => 'max:1024',
                'country' => 'max:1024',
            ]),
        );

        return back()
            ->with('message', $response['message'])
            ->with('state', $response['state'])
            ->withInput();
    }

    public function edit(MailerLiteApi $mailerLite, int $id)
    {
        $response = $mailerLite->getSubscriber($id);

        if (
            isset($response['state']) &&
            $response['state'] === MailerLiteApi::FAILED
        ) {
            return back()
                ->with('message', $response['message'])
                ->with('state', $response['state']);
        }

        return view('subscribers.edit', [
            'subscriber' => json_decode($response, true)['data'],
        ]);
    }

    public function update(MailerLiteApi $mailerLite, int $id)
    {
        $response = $mailerLite->updateSubscriber(
            request()->validate([
                'name' => 'max:1024',
                'last_name' => 'max:1024',
                'country' => 'max:1024',
            ]),
            $id,
        );

        return back()
            ->with("subscriber['id']", $id)
            ->with('message', $response['message'])
            ->with('state', $response['state'])
            ->withInput();
    }

    public function destroy(MailerLiteApi $mailerLite, int $id)
    {
        $mailerLite->deleteSubscriber($id);
    }
}