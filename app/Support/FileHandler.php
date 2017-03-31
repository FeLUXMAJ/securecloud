<?php namespace App\Support;

use App\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Trait FileHandler
 *
 * some methods to handle files on filesystem level
 */
trait FileHandler
{

    /**
     * removes a file physically and in the database
     */
    public function remove()
    {

        // delete it phsically
        Storage::delete($this->getAttribute('file_path'));

        // delete the db record
        $this->delete();

    }


    /**
     * saves a uploaded file
     *
     * @param UploadedFile   $file
     * @return File App\File $file
     */
    public static function saveUploadedFile(UploadedFile $file)
    {

        // get some informations
        $filename  = self::generateUniqueFilename();
        $extension = $file->getClientOriginalExtension();

        // set the path
        $filesPath = storage_path( self::USER_PATH . '/');

        // create a database record
        self::create([
            'user_id' => Auth::id(),
            'file_name' => $filename,
            'file_name_original' => $file->getClientOriginalName(),
            'file_path' => $filesPath . $filename . '.' . $extension,
            'file_extension' => $extension,
            'file_state' => self::STATE_DATA
        ]);

        // store the file on the filesystem
        $file->storeAs($filesPath, $filename . '.' . $extension);

		// return File Object
        return $file;

    }


	/**
	 * check if a file physically exists
	 *
	 * @return bool
	 */
	public function exists()
	{
		return Storage::exists($this->getAttribute('file_path'));
	}


}