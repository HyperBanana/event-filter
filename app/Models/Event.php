<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

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

    public function getDatetimeAttribute($value)
    {
        return Carbon::parse($value)->locale('lv')->translatedFormat('d. F');
    }
}
