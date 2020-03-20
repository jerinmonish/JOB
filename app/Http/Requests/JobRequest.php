<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        $rules['job_title']         = 'required';
        $rules['organisation_name'] = 'required';
        $rules['job_type']          = 'required';
        $rules['max_exp']           = 'required';
        $rules['req_qualification'] = 'required';
        $rules['max_sal']           = 'required';
        $rules['description']       = 'required';
        $rules['no_of_pos']         = 'required';
        $rules['req_email']         = 'required';
        $rules['phone_no']          = 'required';
        $rules['job_keywords']      = 'required';
        $rules['location']          = 'required';
        $rules['status']            = 'required';
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            break;
            case 'POST':
            {
                $rules['job_title'] = 'required';
            }
            case 'PUT':
            case 'PATCH':
            {
            }
            break;
        default:break;
        }
        return $rules;
    }
}
