<?php namespace App\Support;

use App\File;
use App\User;
use App\Facades\FaceApi;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;


/**
 * This Class contains the logic for the
 * registration and login tasks
 *
 * @package App\Support
 */
class AuthenticationHelper
{

    /**
     * register the user on our system
     * add new db record
     * add a person on FaceApi
     * add a persons face on FaceApi
     *
     * @param RegisterRequest $request
     */
    public function registerUser(RegisterRequest $request)
    {

        $this->createUserAndLogin($request);

        $file = $this->saveBase64Photo($request->get('photo'));

        FaceApi::createPerson($request->get('name'));

        FaceApi::addPersonFace($file);

    }


    /**
     * the actual authentication process
     *
     * @param LoginRequest $request
     * @return mixed Answer from FaceApi
     */
    public function compareFaces(LoginRequest $request)
    {

        // save the base64 photo physically
        $file = $this->saveBase64Photo($request->get('photo'));

        // get face ID from user image
        $faceId = FaceApi::detectFace($file);

        // compare the two faces
        $faceComparison = FaceApi::verifyFace($faceId, $request->get('name'));

        // cleanup
        $file->remove();

        // return the result of the comparison
        return $faceComparison;

    }


    /**
     * saves a base64 image string to a png file
     *
     * @param String $base64
     * @return File App\File
     */
    private function saveBase64Photo(String $base64)
    {

        // remove data url chars at the beginning of string
        $base64 = substr($base64, 22);

        // replace all spaces
        $base64 = str_replace(' ', '+', $base64);

        // decode the image
        $image = base64_decode($base64);

        // store the image
        return $this->storeAuthenticationImage($image, 'png');

    }


    /**
     * create user record in the database
     * and log him in
     *
     * @param $request
     */
    private function createUserAndLogin($request)
    {

		// get all request data
        $request = $request->all();

		// crypt the password
        $request['password'] = bcrypt($request['password']);

		// create the user in the db
        $user = User::create($request);

		// log in the currently created user
        Auth::login($user);

    }


    /**
     * store an image that comes from authentication process
     *
     * @param $content image binary data
     * @param $extension filename extension
     *
     * @return File App\File
     */
    private function storeAuthenticationImage($content, $extension)
    {

        // set some informations for the file
        $fileName = File::generateUniqueFilename();
        $filePath = storage_path(File::AUTH_PATH) . '/' . $fileName . '.' . $extension;

        // create the file physically
        Storage::put($filePath, $content);

        // create a database record
        return File::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_extension' => $extension,
            'file_state' => File::STATE_AUTH
        ]);

    }

}