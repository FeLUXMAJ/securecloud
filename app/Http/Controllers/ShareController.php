<?php namespace App\Http\Controllers;

use App\File;
use App\FileShare;
use App\Support\AjaxResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{

	use AjaxResponse;


	/**
	 * create a file share
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{

		// create file share
		$fileShare = FileShare::create([
			'user_id' => Auth::id(),
			'hash' => str_random(42),
			'files' => json_encode($request->all())
		]);

		// return success and share url
		return $this->ajaxResponse(self::$SHARE_CREATED, [
			'link' => route('share.show', $fileShare->hash)
		]);

	}


	/**
	 * display the resource
	 *
	 * @param String $hash
	 *
	 * @return \Illuminate\View\View
	 */
	public function show(String $hash)
	{

		// get information about the file share
		$fileShare = FileShare::whereHash($hash)->first();

		// if file share is not found, abort with 404
		if( ! $fileShare ) {
			abort(404);
		}

		// get file ids
		$fileIds = json_decode($fileShare->files);

		// get files from db
		$files = File::whereIn('id', $fileIds)->get();

		// get username
        $username = $fileShare->user->name;

		// return view
		return view('share.show', compact('files', 'hash', 'username'));

	}


	/**
	 * show the file shares by user
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		$fileShares = FileShare::whereUserId(Auth::id())->get();

		return view('share.index', compact('fileShares'));

	}


	/**
	 * delete a resource
	 *
	 * @param String $hash
	 *
	 * @return Response
	 */
	public function delete(String $hash)
	{

		$fileShare = FileShare::whereHash($hash)->firstOrFail();

		$fileShare->delete();

		return $this->ajaxResponse(self::$SHARE_DELETED);

	}

}
