<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['user_name','user_identifier','message'];

    public function scopeGetData($query)
    {
        return $this->created_at . '　@' . $this->user_name . '　' . $this->message;
    }
}
