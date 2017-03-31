<?php namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User | Model
 */
class User extends Authenticatable
{
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'person_id', 'face_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the comments for the blog post.
     */
    public function fileShares()
    {
        return $this->hasMany('App\FileShare');
    }


	/**
	 * stores a person id on the currently logged in user
	 *
	 * @param String $personId
	 */
	public function storePersonId(String $personId)
    {
        
        $this->attributes['person_id'] = $personId;
        
        $this->save();
        
    }


	/**
	 * stores a face id on the currently logged in user
	 *
	 * @param String $faceId
	 */
    public function storeFaceId(String $faceId)
    {

        $this->attributes['face_id'] = $faceId;

        $this->save();

    }


	/**
	 * get a user by its name
	 *
	 * @param String $name
	 *
	 * @return App\User $user
	 */
	public static function getUserByName(String $name)
    {

		// get user from db
        $user = self::where('name', $name)->firstOrFail();

        return $user;

    }

}
