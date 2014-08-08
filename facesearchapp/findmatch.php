


<?php
/*
* Copyright (C) 2013 Orbeus Inc.
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/
//  Author: Tianqiang Liu - tqliu@orbe.us

$GLOBALS['REKOGNITION_ROOT'] = "SDK/";
require_once 'SDK/config.php';
require_once 'SDK/Rekognition_API.php';
require_once 'SDK/Rekognition_GUI.php';

/*echo "Before analyzing:<br><br><img src='dataset/test.jpg'></img><br><br>";*/

$dirpics = "dataset/";
$test = "dataset/test.jpg";
$face0 = "dataset/face0.JPG";
$face1 = "dataset/face1.jpg";
$face2 = "dataset/face2.jpg";
$face3 = "dataset/face3.jpg";
$face4 = "dataset/face4.jpg";
$dest = "dataset/destination.jpg";
$nameface0 = "source";
$nameface1 = "face1";
$nameface2 = "face2";
$nameface3 = "face3";
$nameface4 = "face4";
$nametest = "test";

$nothing = "";

$namedest = "destination";

global $rekognition;
$resize_factor = 0.5;

$starttime = microtime(true);

$name_list = array('_no_image');

echo "Before analyzing:<br><br><img src='dataset/test.jpg'></img><br><br>";

$parsed_rkfacevisualize = $rekognition->RkFaceVisualize($name_list , Rekognition_API::RETURN_JSON);

echo "(facevisualize) List the faces found an store in an array<br><br>";
//var_dump($parsed_rkfacevisualize);
$links = json_decode($parsed_rkfacevisualize, TRUE);

$stack = array();

foreach($links['visualization']  as $item) {
	
	foreach($item['index'] as $matches) {
		
		echo "Index: " . $matches . "<br><br>";
		array_push($stack,$matches);		
		
	}  
	echo "Tag: " . $item['tag'] . "<br><br>";
	echo "Total Img: " . $item['total_img'] . "<br><br>"; 
	echo "-----------------------------------------------<br><br>";
}

echo "Faces stored in the array<br><br>";

foreach ($stack as $value) {
  echo "$value <br>";
}

echo "<br><br>";

echo "(facevisualizedelete) Delete all faces<br><br>";

$parsed_rkfacedelete = $rekognition->RkFaceDelete($nothing , $stack, Rekognition_API::RETURN_JSON);
var_dump($parsed_rkfacedelete);
//var_dump($parsed_rkfaceadd);

echo "<br><br>";

if (!(bool)$parsed_rkfacedelete) {
    print "This object is empty";
} else {
    print "There is data!";
}

echo "<br>testing1--------<br>";

$links = json_decode($parsed_rkfacedelete, TRUE);

echo "<br>testing2--------<br>";

if ((bool)$parsed_rkfacedelete) {
	foreach ($links as $item){
	    echo "Status : " . $item['status'] . "<br><br>";
	}
}
echo "<br>testing3--------<br>";

echo "faceadd:<br><br>";
faceadd($test, $nameface0, $rekognition, $resize_factor);
faceadd($face0, $nameface0, $rekognition, $resize_factor);
echo "<br>testing4--------<br>";
faceadd($face1, $nameface1, $rekognition, $resize_factor);
faceadd($face2, $nameface2, $rekognition, $resize_factor);
faceadd($face3, $nameface3, $rekognition, $resize_factor);
faceadd($face4, $nameface4, $rekognition, $resize_factor);
faceadd($face5, $nameface4, $rekognition, $resize_factor);

echo "facevisualtrain:<br><br>";

$parsed_rkfacetrain = $rekognition->RkFaceTrain(Rekognition_API::RETURN_JSON);

echo "<br><br>";

$parsed_rkfacevisualize = $rekognition->RkFaceVisualize($name_list , Rekognition_API::RETURN_JSON);

echo "facevisualize:<br><br>";
//var_dump($parsed_rkfacevisualize);

echo "<br><br>";
echo "facetrain:<br><br>";

$links = json_decode($parsed_rkfacetrain, TRUE);
//var_dump($parsed_rkfacetrain);

echo "<br><br>";
foreach ($links as $item){
    echo "Status : " . $item['status'] . "<br><br>";
}

$parsed_rkfacesearch = $rekognition->RkFaceSearch($dest, $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);

facesearchresult($parsed_rkfacesearch);

$endtime = microtime(true);
$timediff = $endtime - $starttime;
//echo "Total Time: " . $timediff . "<br><br>";
//<p style="background-color:yellow"> "total time"</p>


printf('It took %.5f sec', $timediff);



function facesearchresult($parsed_rkfacesearch){
	echo "Get response general information facesearch:<br><br>";
	var_dump($parsed_rkfacesearch);
	$links = json_decode($parsed_rkfacesearch, TRUE);

	echo "<br><br>";
	foreach($links['face_detection']  as $item) {
		
		foreach($item['matches'] as $matches) {
			echo "Tag: " . $matches['tag'] . "<br><br>";
			echo "Image Index: " . $matches['img_index'] . "<br><br>";
			echo "Score: " . $matches['score'] . "<br><br>";
			echo "<br><br>";
		}    
	}
}

function faceadd($req,$name,$rekognition,$resize_factor) {	
	
	echo "Filename: " . $req . "<br><br>";
	echo "Before analyzing:<br><br><img src=$req></img><br><br>";
	$parsed_rkfaceadd = $rekognition->RkFaceAdd($req, $name , $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);
	
	var_dump($parsed_rkfaceadd);
	$links = json_decode($parsed_rkfaceadd, TRUE);
	
	foreach($links['face_detection'] as $item) {
	    echo "Image Index: " . $item['img_index'] . "<br><br>";
	}	
 
}

?>




