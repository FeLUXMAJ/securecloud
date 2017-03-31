<?php namespace App\Http\Controllers;

use App\File;

class CloudController extends Controller
{

	/**
	 * Show the users files
	 *
	 * @return \Illuminate\View\View View
	 */
	public function index()
    {

		// get all files from the current user
        $files = File::userFiles()->get();

		// if the request wants json, just return the collection
		// laravel automatically parses the Object to json
        if( request()->wantsJson() ) {
			return $files;
		}

		// return the view if we access the page in the browser
        return view('cloud.index', compact('files'));

    }

}