<?php namespace App\Support\Request;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * Abstract Class Request
 *
 * provides the core logic of making an
 * api request to the face api
 *
 */
abstract class Request
{

    // some helper methods for setting up the request
    use RequestSetup;


    /** @var String $url The Url of the api call */
    protected $url;

    /** @var Array $data The Json Data of the api call */
    protected $data;

    /** @var User $user The current user */
    protected $user;

    /** @var Array $headers The header data of the api call */
    protected $headers;

    /** @var Array $options An Array for the api call consisting of headers and data */
    protected $options;


    /**
     * Request constructor
     * Get the current user object
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }


	/**
	 * Set the url of the request by the method name of
	 * the caller.
	 * Get the base url from the config and apply the
	 * resource parameters which are necessary
	 * for the api request.
	 *
	 * @param String $method
	 */
	protected function setUrlByMethod(String $method)
    {

		// get base url from config
        $url = Config::get('api.base_url');

		// set required resource parameters at
		// the full url
        $resource = $this->setResourceParams(
        	// get the endpoint of the request
            $this->getResourceByMethod($method)
        );

		// make the complete url available for the class
		// for later use
        $this->url = $url . $resource;

    }


	/**
	 * set data on the json body of the request
	 *
	 * @param array $data
	 */
	protected function setData(Array $data) {

        $this->data = $data;

    }


	/**
	 * process the request
	 *
	 * @return mixed
	 */
	protected function processRequest()
    {

        // check correct calling of methods
        $this->checkRequiredParams();

        // set some headers
        $this->setHeaders();

        // build options array (headers, data)
        $this->setRequestOptions();

        // send the request and return response
        return $this->sendRequest();

    }


	/**
	 * was data and url set correctly?
	 *
	 * @throws InvalidParameterException
	 */
	private function checkRequiredParams()
    {

        if( is_null($this->data) || is_null($this->url) ) {
			throw new InvalidParameterException(
				'please set url and data by calling the following methods:
                    - $this->setUrlByMethod(__FUNCTION__)
                    - $this->setData([])'
			);
		}

    }


	/**
	 * make the required headers available for the class
	 */
	private function setHeaders()
    {

        $this->headers = [
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => Config::get('api.key'),
        ];

    }


	/**
	 * built an options array for the request
	 * which contains headers and the json data
	 */
	private function setRequestOptions()
    {

        // fill array with predefined headers
        $this->options = [
            'headers' => $this->headers
        ];

        // set json body if necessary
        if( ! empty($this->data) ) {
			$this->options['json'] = $this->data;
		}

    }


	/**
	 * send the request via GuzzleHttp
	 *
	 * @return mixed
	 */
	private function sendRequest()
    {

        try {

            $response = (new Client)->post(
                $this->url, $this->options
            );

        } catch(RequestException $e) {

            // todo: development code, change it!
            dd( "REQUEST EXCEPTION", json_decode($e->getResponse()->getBody()->getContents()), $e->getRequest(), $e->getResponse() );
            // json_decode($e->getResponse()->getBody()->getContents()

        }

        // todo: build an responseObject for unified responses!
        return json_decode($response->getBody()->getContents());

    }

}