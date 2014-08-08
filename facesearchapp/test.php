
<?php

$name_space = 'facesearchapp';
$user_id = 'user001'; 

$GLOBALS['REKOGNITION_ROOT'] = "SDK/";
require_once 'SDK/config.php';
require_once 'SDK/Rekognition_API.php';
require_once 'SDK/Rekognition_GUI.php';
require_once 'SDK/HttpClient.class.php';

global $rekognition;
$resize_factor = 0.5;
$dest = "dataset/destination.jpg";

$urlface1 = 'http://facesearchapp.herokuapp.com/dataset/face1.jpg';
$urlface2 = 'http://facesearchapp.herokuapp.com/dataset/face2.jpg';
$urlface3 = 'http://facesearchapp.herokuapp.com/dataset/face3.jpg';
$urlface4 = 'http://facesearchapp.herokuapp.com/dataset/face4.jpg';
$urlface5 = 'http://facesearchapp.herokuapp.com/dataset/face5.jpg';
$urlface6 = 'http://facesearchapp.herokuapp.com/dataset/face6.jpg';
$urlface7 = 'http://facesearchapp.herokuapp.com/dataset/face7.jpg';
$urlface8 = 'http://facesearchapp.herokuapp.com/dataset/face8.jpg';
$urlface9 = 'http://facesearchapp.herokuapp.com/dataset/face9.jpg';
$tagface1 = 'face1tag'; 
$tagface2 = 'face2tag'; 
$tagface3 = 'face3tag'; 
$tagface4 = 'face4tag'; 
$tagface5 = 'face5tag'; 
$tagface6 = 'face6tag'; 
$tagface7 = 'face7tag'; 
$tagface8 = 'face8tag'; 
$tagface9 = 'face9tag'; 

facedelete($name_space);

echo "---------------add faces-------------------<br><br>";

//echo "Before analyzing face0tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face0.JPG'></img><br><br>";
echo "face1tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face1.jpg'></img><br><br>"; 

faceadd($urlface1, $tagface1, $name_space, $user_id);

echo "face2tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face2.jpg'></img><br><br>";

faceadd($urlface2, $tagface2, $name_space, $user_id);

echo "face3tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face3.jpg'></img><br><br>";

faceadd($urlface3, $tagface3, $name_space, $user_id);

echo "face4tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face4.jpg'></img><br><br>";

faceadd($urlface4, $tagface4, $name_space, $user_id);

echo "face5tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face5.jpg'></img><br><br>";

faceadd($urlface5, $tagface5, $name_space, $user_id);

echo "face6tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face6.jpg'></img><br><br>";

faceadd($urlface6, $tagface6, $name_space, $user_id);

echo "face7tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face7.jpg'></img><br><br>";

faceadd($urlface7, $tagface7, $name_space, $user_id);

echo "face8tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face8.jpg'></img><br><br>";

faceadd($urlface8, $tagface8, $name_space, $user_id);

echo "face9tag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/face9.jpg'></img><br><br>";

faceadd($urlface9, $tagface9, $name_space, $user_id);

echo "targettag :<br><br><img src='http://facesearchapp.herokuapp.com/dataset/destination.jpg'></img><br><br>";


echo "<br><br>------------train------------------------<br><br>";

facetrain($name_space, $user_id);


echo "<br><br>------------visualize------------------------<br><br>";

facevisualize($name_space, $user_id);

echo "<br><br>------------search------------------------<br><br>";

facesearch($name_space, $user_id);

function facesearch($name_space, $user_id)
{
	$parameters = array(
      'api_key' => 'qoMOgcBJV4j38aig', 
      'api_secret' => 'Sgylmse8nbBFQtmk', 
      'jobs' => 'face__search_nodetect',
      'urls' => 'http://facesearchapp.herokuapp.com/dataset/destination.jpg',
      'name_space' => $name_space,
      //'query_tag' => 'desttag',
      //'img_index' => '1514652',
      'num_return' => 1,
      'user_id' => $user_id
      );
      
	$face_detection = new HttpClient('rekognition.com');
	$face_detection->setDebug(false);
	$response = $face_detection->get("/func/api/", $parameters);

	//echo "Parameters : " . $parameters . "<br><br>";
	//var_dump($parameters);
	//echo "<br><br>";
			
	//echo $face_detection->getContent();

	$parsed_rkfacesearch = $face_detection->getContent();

	//echo "<br><br>";

	echo "Get response general information facesearch:<br><br>";
	/*var_dump($parsed_rkfacesearch);*/
	$links = json_decode($parsed_rkfacesearch, TRUE);

	echo "<br><br>";

	$array2 = array();
	
	foreach($links['face_detection']  as $item) {
		/*
		echo "Tag: " . $item['tag'] . "<br><br>";
		echo "Image Index: " . $item['img_index'] . "<br><br>";
		echo "Score: " . $item['score'] . "<br><br>";
		*/
		
		
		foreach($item['matches'] as $matches) {
			echo "Tag: " . $matches['tag'] . "<br><br>";
			echo "Image Index: " . $matches['img_index'] . "<br><br>";
			echo "Score: " . $matches['score'] . "<br><br>";
			$array1 = array('tag' => $matches['tag'], 'img_index' => $matches['img_index'] , 'score' => $matches['score'] );
			array_push($array2 ,$array1);
			//echo "<br><br>";
		} 
		
		echo "------------------------------------<br><br>";  
	}

	//print_r($array2 );
	//echo "<br><br>";
	//var_dump($array2);
	//echo "<br><br>";

	echo "<br>------b4----<br>";

	for ($i = 0; $i < count($array2); ++$i) {
		
        	echo $array2[$i]['tag'] . " " . $array2[$i]['img_index'] . " " . $array2[$i]['score'] ."<br><br>";
    	
    }
    

	usort($array2, 'cmp');

	//echo "<br>------after----<br>";

	for ($i = 0; $i < count($array2); ++$i) {
		echo $array2[$i]['tag'] . " " . $array2[$i]['img_index'] . " " . $array2[$i]['score'] ."<br><br>";
    }

    echo "<br><br>------------Best Match------------------------<br><br>";
    echo "<br><br>" .$array2[count($array2) - 1]['tag']. " " .$array2[count($array2) - 1]['score'] . "<br><br>";
    echo "<br><br>------------Best Match------------------------<br><br>";
	
}



function facevisualize($name_space, $user_id)
{
	$parameters = array(
      'api_key' => 'qoMOgcBJV4j38aig',
      'api_secret' => 'Sgylmse8nbBFQtmk',
      'jobs' => 'face_visualize',      
      'name_space' => $name_space,
      'user_id' => $user_id
      );
      
	$face_detection = new HttpClient('rekognition.com');
	$face_detection->setDebug(false);
	$response = $face_detection->get("/func/api/", $parameters);

	//echo "Parameters : " . $parameters . "<br><br>";
	//var_dump($parameters);	

	echo $face_detection->getContent();

	echo "<br><br>";
}

function facetrain($name_space, $user_id)
{
	$parameters = array(
      'api_key' => 'qoMOgcBJV4j38aig',
      'api_secret' => 'Sgylmse8nbBFQtmk',
      'jobs' => 'face_train',
      'name_space' => $name_space,
      'user_id' => $user_id
      );
      
	$face_detection = new HttpClient('rekognition.com');
	$face_detection->setDebug(false);
	$response = $face_detection->get("/func/api/", $parameters);

	//echo "Parameters : " . $parameters . "<br><br>";
	//var_dump($parameters);	
			
	echo $face_detection->getContent();

	echo "<br><br>";
}

function facedelete($name_space)
{
	echo "<br><br>------------delete all faces------------------------<br><br>";

	$parameters = array(
	      'api_key' => 'qoMOgcBJV4j38aig',
	      'api_secret' => 'Sgylmse8nbBFQtmk',
	      'jobs' => 'face_delete',      
	      'name_space' => $name_space, 
	      //'img_index' => '1033962;1111760',     
	      //'user_id' => $user_id
	      );
	      
	$face_detection = new HttpClient('rekognition.com');
	$face_detection->setDebug(false);
	$response = $face_detection->get("/func/api/", $parameters);

	//echo "Parameters : " . $parameters . "<br><br>";
	//var_dump($parameters);

			
	echo $face_detection->getContent();

	echo "<br><br>";
}

function faceadd($url, $tag, $name_space, $user_id )
{
	echo "<br><br>------------Add------------------------<br><br>";

	$parameters = array(
	      'api_key' => 'qoMOgcBJV4j38aig',
	      'api_secret' => 'Sgylmse8nbBFQtmk',
	      'jobs' => 'face_add',
	      'urls' => $url,
	      'name_space' => $name_space,
	      'tag' => $tag,
	      'user_id' => $user_id
	      );
	      
	$face_detection = new HttpClient('rekognition.com');
	$face_detection->setDebug(false);
	$response = $face_detection->get("/func/api/", $parameters);

	//echo "Parameters : " . $parameters . "<br><br>";
	//var_dump($parameters);	
			
	echo $face_detection->getContent();

	echo "<br><br>";
}

function cmp($a, $b)
{
    return strcmp($a['score'], $b['score']);
}

?>