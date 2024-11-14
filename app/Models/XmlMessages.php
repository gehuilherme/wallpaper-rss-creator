<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * XmlMessagesModel
 *
 * @author Guilherme Miranda <miranda.guilherme@made4it.com.br>
 */
final class XmlMessages extends Model
{
    use HasFactory, Notifiable;

    protected $table = "xml_messages";

    protected $fillable = [
        'title',
        'subtitle',
        'button_link',
        'img_link',
        'message_channel',
        'image_priority',
    ];
}
