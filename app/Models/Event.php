<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Event extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'events';

    protected $fillable = [
        'id',
        'datetime',
        'title',
        'full_text',
        'type',
        'lead_image'
    ];

    public $timestamps = false;
    
/*     public static function all($columns = ['*'])
    {
        $json = Storage::disk('local')->get('mock_events.json');
        $events = json_decode($json);
        return $events;
    } */
}
