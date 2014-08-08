<?php
require_once '../SDK/HttpClient.class.php';

$parametersadd = array(
      'api_key' => '1234',
      'api_secret' => '5678',
      'jobs' => 'face_add_aggressive',
      'urls' => 'dataset/source.jpg',
      'name_space' => 'test_example',
      'user_id' => 'test_example'
      );

$parameterstrain = array(
      'api_key' => '1234',
      'api_secret' => '5678',
      'jobs' => 'face_train',
      'name_space' => 'test_example',
      'user_id' => 'test_example'
      );
 
$parameterssearch = array(
      'api_key' => '1234', 
      'api_secret' => '5678', 
      'jobs' => 'face_inner_search',
      'name_space' => 'test_example',
      'user_id' => 'test_example',
      'query_tag' => 'sting',
      'img_index' => '1275316'
      );
      
$face_detection = new HttpClient('rekognition.com');
$face_detection->setDebug(true);
$response = $face_detection->get("/func/api/", $parametersadd);
		
echo $face_detection->getContent();
?>