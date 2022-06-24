<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    public function chat_thread()
    {
        return $this->belongsTo(ChatThread::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
