<?php namespace App\Support\Request;

use Illuminate\Support\Facades\Config;

/**
 * Trait RequestSetup
 *
 * Some userfull methods for setting up
 * an api request
 */
trait RequestSetup
{

	/**
	 * fetches the endpoints with placeholder by the
	 * method name of the caller
	 *
	 * @param String $method
	 *
	 * @return String $endpoint
	 */
	protected function getResourceByMethod(String $method)
    {

        return Config::get('api.resources.' . snake_case($method));

    }


	/**
	 * replace the placeholder in the endpoint url with
	 * required values
	 *
	 * @param String $resource
	 *
	 * @return String $endpoint
	 */
	protected function setResourceParams(String $resource)
    {

		// the placeholders which will be replaced
        $personGroupId = '{personGroupId}';
        $personId      = '{personId}';

		// as long as there are placeholder ...
        while( str_contains($resource, ['{', '}']) ) {

            switch(true) {

				// replace person group string
                case str_contains($resource, $personGroupId):
                    $resource = str_replace($personGroupId, $this->getPersonGroupId(), $resource);
                    break;

				// replace person id string
                case str_contains($resource, $personId):
                    $resource = str_replace($personId, $this->getPersonId(), $resource);
                    break;

                default:
                    // replace nothing
                    break;

            }

        }

        return $resource;

    }


	/**
	 * returns our pre defined person group
	 *
	 * @return String $personGroupID
	 */
	private function getPersonGroupId()
    {
        return Config::get('api.person_group_id');
    }


	/**
	 * return the person id from the currently
	 * logged in user
	 *
	 * @return String $personID
	 */
	private function getPersonId()
    {
        return $this->user->person_id;
    }

}