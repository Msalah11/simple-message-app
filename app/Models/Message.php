<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'user_id'];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        // When creating a new message, encrypt the message content
        static::creating(function ($message) {
            $message->message = Crypt::encryptString($message->message);
        });

        // When retrieving a message, decrypt the message content
        static::retrieved(function ($message) {
            $message->message = Crypt::decryptString($message->message);
        });
    }
}
