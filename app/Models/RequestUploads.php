<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestUploads extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_request';
    protected $table = 'request_uploads';
    
    protected $fillable = [
        'id_requesting_user',
        'status',
        'id_analysis_user',
        'observation',
    ];

    public function requestingUser()
    {
        return $this->belongsTo(User::class, 'id_requesting_user');
    }

    public function analysisUser()
    {
        return $this->belongsTo(User::class, 'id_analysis_user');
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'id_request');
    }
}
