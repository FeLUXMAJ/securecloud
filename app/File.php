<?php namespace App;

use App\Support\FileHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * Class File | Model
 */
class File extends Model
{

    use FileHandler;

	/**
	 * some enum-like constants
	 */
    const STATE_AUTH = 1; // images from authentication process
    const STATE_DATA = 2; // user data

    const AUTH_PATH = 'auth'; // filesystem path for authentication images
    const USER_PATH = 'user'; // filesystem path for user data

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [
        'user_id', 'file_name', 'file_name_original', 'file_path', 'file_extension', 'file_state'
    ];


    /**
     * get all files from the currently logged in user
     *
     * @param $query
     * @return Builder QueryBuilder
     */
    public function scopeUserFiles($query)
    {
        return $query->whereFileState(self::STATE_DATA)->whereUserId(Auth::id());
    }


    /**
     * generates a unique filename
     *
     * @return string
     */
    public static function generateUniqueFilename()
    {

        while(true) {

            $random = str_random(42);

            $matches = File::whereFileName($random)->count();

            if( ! $matches ) {
				return $random;
			}

        }

    }


	/**
	 * returns a public reachable link for a file
	 * used in authentication process to pass
	 * an image to the face api
	 *
	 * @return String $url
	 */
	public function getPublicUrl()
    {

        return route('file.show', $this->getAttribute('file_name'));

    }


	/**
	 * checks if a file belongs to a user
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function belongsToUser(User $user)
	{
		return $this->getAttribute('user_id') == $user->id;
    }

}
