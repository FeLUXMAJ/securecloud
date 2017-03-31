<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade FaceApi
 * Call the Api Request Methods from here.
 * Example: FaceApi::createPerson()
 *
 * @method static string createPerson()
 * @method static string addPersonFace()
 * @method static string detectFace()
 * @method static string verifyFace()
 */
class FaceApi extends Facade
{

    protected static function getFacadeAccessor()
    {

        return 'FaceApi';

    }

}