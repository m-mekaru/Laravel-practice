<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',        
        'description',  
        'assigned_user_id', 
        'task_status'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
    public static function createFromRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (($data['assigned_user_id'] ?? '') === 'me') {
                $data['assigned_user_id'] = Auth::id();
            }
            return self::create($data);
        });
    }

    public function updateFromRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (($data['assigned_user_id'] ?? '') === 'me') {
                $data['assigned_user_id'] = Auth::id();
            }
            return $this->update($data);
        });
    }
}
