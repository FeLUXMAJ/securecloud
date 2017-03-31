<?php namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\DeleteFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Support\AjaxResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    use AjaxResponse;


	/**
	 * upload users files
	 *
	 * @param UploadFileRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function uploadFiles(UploadFileRequest $request)
    {

		// get file Objects from Request
        $files = array_get($request->allFiles(), 'files');

        foreach ($files as $file) {
            File::saveUploadedFile($file);
        }

        return $this->ajaxResponse(self::$UPLOAD_COMPLETE);

    }


	/**
	 * get file by hash for public access
	 * (images for face api)
	 *
	 * @param String $hash
	 *
	 * @return Response File
	 */
	public function show(String $hash)
    {

		// get file by hash
        $file = File::whereFileName($hash)->first();

		// check existance
        if( ! $file || ! $file->exists() ) {
            abort(404);
        }

        // return file response
        return response()->file($file->file_path);

    }


	/**
	 * delete a resource
	 *
	 * @param DeleteFileRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(DeleteFileRequest $request)
    {

		// get current user
        $user = Auth::user();

		// get file ids which should be deleted
        $fileIds = $request->all();

		// get file objects from db
        $files = File::whereIn('id', $fileIds)->get();

		/** @var File $file */
		foreach ($files as $file) {
            // if file exists and belongs to user, delete it
            if( $file->exists() && $file->belongsToUser($user) ) {
                $file->remove();
            }
        }

        // return success
        return $this->ajaxResponse(self::$FILES_DELETED);

    }


	/**
	 * download a file
	 *
	 * @param String      $fileHash
	 * @param String|null $shareHash
	 *
	 * @return Response Download
	 */
	public function download(String $fileHash, String $shareHash = null)
    {

		// get file
        $file = File::whereFileName($fileHash)->firstOrFail();

		// check file existance
		if( ! $file->exists() ) {
			abort(404);
		}

		// auth check if we are not on a share
		if( is_null($shareHash) && ! $file->belongsToUser(Auth::user()) ) {
			abort(404);
		}

		// return download response
        return response()->download($file->file_path, $file->file_name_original);

    }

}
