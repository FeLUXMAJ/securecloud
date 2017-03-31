<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FileShare | Model
 */
class FileShare extends Model
{

	// the table in the database
    protected $table = 'file_shares';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'expire_on', 'files', 'hash'
	];

    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
