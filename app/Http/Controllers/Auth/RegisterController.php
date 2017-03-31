<?php namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Support\AjaxResponse;
use App\Support\AuthenticationHelper;
use App\Support\RegistrationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers,
        AjaxResponse;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @param AuthenticationHelper $authenticationHelper
     *
     * @return \Illuminate\Http\Response Ajax Response
     */
    public function register(RegisterRequest $request, AuthenticationHelper $authenticationHelper)
    {

        $authenticationHelper->registerUser($request);

        return $this->ajaxResponse(self::$REGISTRATION_SUCCESS);

    }

}
