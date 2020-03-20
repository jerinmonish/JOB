<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProfileUpdateRequest extends FormRequest
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
        if(Auth::user()->role == "employee"){
            $rules['job_type']              = 'required';
            $rules['schoolmark']            = 'required';
            $rules['collegemark']           = 'required';
            $rules['highest_qualification'] = 'required';
            $rules['year_passed_out']       = 'required';
            $rules['percentage']            = 'required';
            //$rules['resume_doc']            = 'required';
            $rules['specialised_in']        = 'required';
            $rules['yoe']                   = 'required';
            $rules['cur_sal']               = 'numeric|required';
            $rules['job_type']              = 'required';
            $rules['exp_sal']               = 'numeric|required';
            switch ($this->method()) {
                case 'GET':
                case 'DELETE':
                {
                    return [];
                }
                break;
                case 'POST':
                {
                }
                case 'PUT':
                case 'PATCH':
                {
                }
                break;
            default:break;
            }
        } else if(Auth::user()->role == "employer"){
            $rules['organisation_name'] = 'required';
            $rules['yoe']               = 'required';
            $rules['specialised_in']    = 'required';
            switch ($this->method()) {
                case 'GET':
                case 'DELETE':
                {
                    return [];
                }
                break;
                case 'POST':
                {
                }
                case 'PUT':
                case 'PATCH':
                {
                }
                break;
            default:break;
            }
        }

        $rules['first_name']  = 'required';
        $rules['last_name']   = 'required';
        $rules['dob']         = 'date_format:Y-m-d|required';
        $rules['mobile_no']   = 'numeric|required';
        $rules['state']       = 'required';
        #$rules['city']        = 'required';
        $rules['country']     = 'required';
        $rules['address']     = 'required';

        return $rules;
    }
}
