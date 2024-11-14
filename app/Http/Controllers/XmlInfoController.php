<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\XmlMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\XmlFeedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class XmlInfoController extends Controller
{
    protected $channels = [
        'M4F-BR',
        'M4F-US',
        'M4F-EN',
        'M4G-BR',
        'M4G-US',
        'M4G-EN',
        'M4O-BR',
        'M4O-US',
        'M4O-EN',
    ];

    public function index(): Response
    {
        $feed = XmlFeedService::createFeed();

        $path = storage_path('app/public/feed.xml');
        file_put_contents($path, $feed);

        return response($feed, 200)->header('Content-Type', 'application/xml');
    }


    public function list(): JsonResponse
    {
        return new JsonResponse(XmlMessages::all());
    }

    public function create(): View
    {
        $channels = ['M4F-BR', 'M4F-US', 'M4F-EN', 'M4G-BR', 'M4G-US', 'M4G-EN', 'M4O-BR', 'M4O-US', 'M4O-EN'];
        return view('rssfeed.index', ['channels' => $channels]);
    }

    public function createFeed(Request $request): Redirector|RedirectResponse
    {
        if (!in_array($request->message_channel, $this->channels)) {
            return redirect('/')->with(['status' => ['type' => 'danger', 'message' => 'Use um canal de comunicação válido!']]);
        }

        XmlMessages::create($request->all());

        $newData = XmlFeedService::createFeed();

        $path = storage_path('app/public/feed.xml');
        file_put_contents($path, $newData);

        return redirect('/')->with(['status' => ['type' => 'success', 'message' => 'Criado!']]);
    }

    public function deleteFeed(Request $request)
    {
        XmlMessages::destroy(['id' => $request->id]);

        return redirect('/')->with(['status' => ['type' => 'warning', 'message' => 'Apagado!']]);
    }
}
