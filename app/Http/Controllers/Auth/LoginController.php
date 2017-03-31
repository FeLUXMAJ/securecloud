<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordLoginRequest;
use App\Support\AjaxResponse;
use App\Support\AuthenticationHelper;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,
        AjaxResponse;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @param AuthenticationHelper $authenticationHelper
     *
     * @return \Illuminate\Http\Response AjaxResponse
     */
    public function login(LoginRequest $request, AuthenticationHelper $authenticationHelper)
    {

        // check face against person
        $faceComparison = $authenticationHelper->compareFaces($request);

        // if not the same person
        if( ! $faceComparison->isIdentical )
            return $this->ajaxResponse(self::$LOGIN_FAILED);

        // if confidence is not high enough
        if( $faceComparison->confidence < Config::get('api.confidence_limit') )
            return $this->ajaxResponse(self::$PASSWORD_REQUIRED, ['password_required' => true]);

        // log user in
        Auth::login(
        	User::getUserByName($request->get('name'))
		);

        // send success response
        return $this->ajaxResponse(self::$LOGIN_SUCCESS);

    }


	/**
	 * Log in a user with his credentials
	 *
	 * @param PasswordLoginRequest $request
	 * @param AuthenticationHelper $authenticationHelper
	 *
	 * @return \Illuminate\Http\Response AjaxResponse
	 */
	public function loginWithPassword(PasswordLoginRequest $request, AuthenticationHelper $authenticationHelper)
    {

        $credentials = [
            'name' => $request->get('name'),
            'password' => $request->get('password')
        ];

        if( Auth::attempt($credentials) )
            return $this->ajaxResponse(self::$LOGIN_SUCCESS);

        return $this->ajaxResponse(self::$WRONG_PASSWORD);

    }

}
