<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\XmlMessages;
use Illuminate\Support\Collection;

final class XmlFeedService
{
    protected static $channels = [
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

    public static function createFeed(): string
    {
        $feed = '<?xml version="1.0" encoding="UTF-8"?>';
        $feed .= '<rss version="2.0">';

        foreach (self::$channels as $channel) {
            $channelFeed = self::makeChannelFeed($channel);
            $feed .= $channelFeed;
        }

        $feed .= "</rss>";

        return $feed;
    }

    public static function makeChannelFeed(string $channel): string|null
    {
        $channel = "<!-- $channel --><channel><title>$channel</title>";

        $messages = XmlMessages::where('message_channel', '=', $channel)->orderBy('image_priority', 'asc')->get();

        if ($messages->count() > 0) {
            foreach ($messages as $message) {
                $title = $message->title ?? '';
                $subtitle = $message->subtitle ?? '';
                $buttonLink = $message->button_link ?? '';
                $imgLink = $message->img_link ?? '';

                $channel .= '<item>';
                $channel .= "<title>$title</title>";
                $channel .= "<subtitle>$subtitle</subtitle>";
                $channel .= "<buttonLink>$buttonLink</buttonLink>";
                $channel .= "<linkImg>$imgLink</linkImg>";
                $channel .= '</item>';
            }
        }

        $channel .= "</channel>";

        return $channel;
    }

    public static function getByMessageChannel($channel): Collection
    {
        return XmlMessages::where('message_channel', '=', $channel)->orderBy('image_priority', 'asc')->get();
    }

}
