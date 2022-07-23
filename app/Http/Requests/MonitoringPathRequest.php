<?php

namespace App\Http\Requests;

use App\Rules\IsUniqueMonitoringPath;
use App\Rules\IsUserMonitoringPath;
use Illuminate\Foundation\Http\FormRequest;

class MonitoringPathRequest extends FormRequest
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
        return [
            'name'=>['required', 'string', 'max:255', new IsUniqueMonitoringPath($this->request->get('pathId'))],
            'pathId'=>['sometimes', 'nullable', 'numeric', 'exists:monitorings,id', new IsUserMonitoringPath()],
            'color'=>['sometimes', 'string', 'nullable'],
            'notificationTime'=>['sometimes', 'string']
        ];
    }
}
