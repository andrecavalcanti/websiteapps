<?php
require_once 'HttpClient.class.php';
 
$parameters = array(
      'api_key' => '1234', 
      'api_secret' => '5678', 
      'jobs' => 'face_search',
      'urls' => 'http://rekognition.com/static/img/people.jpg',
      'name_space' => 'test_example',
      'user_id' => 'test_example'
      );
      
$face_detection = new HttpClient('rekognition.com');
$face_detection->setDebug(true);
$response = $face_detection->get("/func/api/", $parameters);
		
echo $face_detection->getContent();
?>