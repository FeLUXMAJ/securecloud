<?php namespace App\Http\Requests;

use App\Support\AjaxResponse;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{

    use AjaxResponse;

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
            'files.*' => 'file|max:25600'
        ];
    }


    public function response(array $errors)
    {

        return $this->ajaxResponse(self::$UPLOAD_FAILED);

    }

}
