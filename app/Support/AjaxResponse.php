<?php namespace App\Support;

use Illuminate\Http\Response;

/**
 * Trait AjaxResponse
 *
 * unified ajax responses for our frontend
 */
trait AjaxResponse
{

    private static $LOGIN_SUCCESS = 'login_success';
    private static $REGISTRATION_SUCCESS = 'registration_success';
    private static $LOGIN_FAILED = 'login_failed';
    private static $WRONG_PASSWORD = 'wrong_password';
    private static $PASSWORD_REQUIRED = 'password_required';
    private static $UPLOAD_COMPLETE = 'upload_complete';
    private static $UPLOAD_FAILED = 'upload_failed';
    private static $FILES_DELETED = 'files_deleted';
	private static $SHARE_CREATED = 'share_created';
	private static $SHARE_DELETED = 'share_deleted';


	/**
	 * sends a ajax response with pre defined data
	 * to trigger a swal() on the frontend
	 *
	 * @param String $type
	 * @param Array  $additionalData
	 *
	 * @return Response Ajax Response
	 */
	private function ajaxResponse(String $type, Array $additionalData = [])
    {

		// get status from translation file
        $status = (int) trans('ajax-response.' . $type . '_http_code');

		// get title, text and status from translation file
        $response = [
            'title' => trans('ajax-response.' . $type . '_title'),
            'text' =>  trans('ajax-response.' . $type . '_text'),
            'status' => trans('ajax-response.' . $type . '_status')
        ];

		// if login or registration success, put some additional data
        if( $type == self::$LOGIN_SUCCESS || $type == self::$REGISTRATION_SUCCESS ) {
            $response['redirect'] = route('cloud-home'); // redirect to home
            $response['delay']    = 3000;				// wait 3 seconds
        }

        // if additional Data is set, merge it into our response
        if( ! empty($additionalData) ) {
			$response = array_merge($response, $additionalData);
		}

		// return the response array as json with status
        return response()->json($response, $status);

    }

}