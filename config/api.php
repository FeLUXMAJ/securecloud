<?php

return [

    // the base url every api call goes to
    'base_url' => 'https://westus.api.cognitive.microsoft.com/face/v1.0/',


    // the api key for making requests
    'key' => '253530610a87404685bfba324c51fd95',


    // the person group every person gets assigned
    'person_group_id' => 'securecloud',


    // these are the different resources of the api
    // will used to build the url at the api call
    'resources' => [
        'create_person' => 'persongroups/{personGroupId}/persons',
        'add_person_face' => 'persongroups/{personGroupId}/persons/{personId}/persistedFaces',
        'detect_face' => 'detect',
        'verify_face' => 'verify'
    ],

	// limit where the application will ask for a password
    'confidence_limit' => 0.75

];