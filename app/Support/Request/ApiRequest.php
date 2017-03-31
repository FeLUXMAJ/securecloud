<?php namespace App\Support\Request;

use App\File;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * Class ApiRequest
 * The available methods from the FaceApi
 * Call these Methods via the FaceApi Facade
 */
class ApiRequest extends Request
{

	/**
	 * first step on our registration process
	 * create a person with a name in a
	 * specified person group
	 *
	 * @param String $name
	 *
	 * @return mixed $response
	 */
	public function createPerson(String $name)
    {

		// define the resource endpoint of the api by setting
		// the url with the current method name
        $this->setUrlByMethod(__FUNCTION__);

		// set data on the json body
        $this->setData([
            'name' => $name
        ]);

		// process request and save it as response
        $response = $this->processRequest();

		// store the person id on users table if request was successfull
        $this->user->storePersonId($response->personId);

		// return the api call response
        return $response;

    }


	/**
	 * second step on our registration process
	 * add a face to the currently
	 * authenticated user
	 *
	 * @param File $file
	 *
	 * @return mixed $response
	 */
	public function addPersonFace(File $file)
    {

        $this->setUrlByMethod(__FUNCTION__);

        $this->setData([
        	// url where the image is public accessable
            'url' => $file->getPublicUrl()
        ]);

        $response = $this->processRequest();

        $this->user->storeFaceId($response->persistedFaceId);

        return $response;

    }


	/**
	 * first step on our authentication process
	 * get a face id for the current image
	 *
	 * @param File $file
	 *
	 * @return mixed $response
	 */
	public function detectFace(File $file)
    {

        $this->setUrlByMethod(__FUNCTION__);

        $this->setData([
        	// url where the image is public accessable
            'url' => $file->getPublicUrl()
        ]);

        $response = $this->processRequest();

        return $response[0]->faceId;

    }


	/**
	 * second step on our authentication process
	 * check if a face id belongs to the
	 * registered user
	 *
	 * @param String $faceId
	 * @param String $name
	 *
	 * @return mixed $response
	 */
	public function verifyFace(String $faceId, String $name)
    {

        $this->setUrlByMethod(__FUNCTION__);

        $this->setData([
        	// the face id to compare
            'faceId' => $faceId,
			// the person id which wants to log in
            'personId' => User::getUserByName($name)->person_id,
			// our person group
			'personGroupId' => Config::get('api.person_group_id')
        ]);

        $response = $this->processRequest();

        return $response;

    }

}