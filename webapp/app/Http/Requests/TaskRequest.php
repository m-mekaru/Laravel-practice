<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'task_status' => 'required|in:未着手,着手中,保留,完了',
            'description' => 'nullable|string',
        ];
    }
}
