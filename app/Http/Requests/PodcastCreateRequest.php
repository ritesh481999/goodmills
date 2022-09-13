<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PodcastCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {  
        // mimes:m4a,mp4a,mp4,wav,ogg,oga,spx,mpga,mp2,mp2a,mp3,m2a,m3a,wma,adp'
        // reference https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
        $rules = [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'audio' => 'required|file|max:104858',  // max =~100 mb
            'image' => 'required|file|mimes:jpeg,jpg,png|max:20999', // max ~+20 mb
            'duration' => 'required|regex:/[0-9]+(\:[0-6][0-9])$/', 
            'status' => 'required|in:0,1',
        ];

        if(request()->route()->getName() === 'podcast.update')
        {
            $rules['audio'] = str_replace('required|', 'nullable|', $rules['audio']);
            $rules['image'] = str_replace('required|', 'nullable|', $rules['image']);
        }
        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
    */
    public function withValidator($validator)
    {
        // dd(request()->audio);
        // dd([
        //     request()->audio->getMimeType(),
        //     request()->audio->getClientMimeType(),
        // ]);
        // $validator->after(function ($validator) {
        //     if(!$validator->errors()->has('audio') && request()->hasFile('audio'))
        //     {
        //         $allows = config('common.podcast_audio_mimetypes');
        //         $clientMime = strtolower( request()->audio->getClientMimeType() );
        //         $guessMime = strtolower( request()->audio->getMimeType() );
        //         if(!in_array($guessMime, $allows) && !in_array($clientMime, $allows))
        //             $validator->errors()->add('audio', 'Please select valid audio file.');
        //     }       
        // });
        $validator->after(function ($validator) {
            if(!$validator->errors()->has('audio') && request()->hasFile('audio'))
            {
                $allows = config('common.podcast_audio_mimetypes');
                $clientExt = strtolower( request()->audio->getClientOriginalExtension() );
                if(!in_array($clientExt, $allows))
                    $validator->errors()->add('audio', 'Please select valid audio file.');
            }       
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
    */
    public function messages()
    {
        return [
            'audio.max' => 'A audio file must be less than 25MB',
            'image.max' => 'A image must be less than 5MB'
        ];
    }
}
