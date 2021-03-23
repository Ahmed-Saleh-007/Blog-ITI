<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        define('MAX_POSTS_ALLOWED', 10);

        $rules = [
            "description"   => ["required", "min:10"],
            'image'         => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png'],
            "user_id"       => ["required", "exists:users,id",function($attribute, $value, $fail) {
                if (Post::where($attribute, $value)->count() >= MAX_POSTS_ALLOWED && !$this->id)
                    $fail('User has Exceeded max post which are ' . MAX_POSTS_ALLOWED);
            }],
        ];

        if ($this->getMethod() == 'POST') {
            $rules += ['title'  => ["required", "min:3", "unique:posts"] ];
        }else {
            $rules += ["title"  => ["required", "min:3", "unique:posts,title," . $this->post->id] ];
        }

        return $rules;
        
    }

    public function messages()
    {
        return [
            'title.min'             => 'The Title has minimum of 3 chars',
            'title.required'        => 'Title is required, you have to fill it!',
            'title.unique'          => 'Title is unique, you have to choose a different title!',
            'description.min'       => 'The Description has minimum of 10 chars',
            'description.required'  => 'Description is required, you have to fill it!',
            'user_id.exists'        => 'This Post Creator doesn\'t exist in the database!!!!', 
        ];
    }
}
