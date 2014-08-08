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

$GLOBALS['REKOGNITION_ROOT'] = "../SDK/";
require_once '../SDK/config.php';
require_once '../SDK/Rekognition_API.php';
require_once '../SDK/Rekognition_GUI.php';

/*echo "Before analyzing:<br><br><img src='dataset/test.jpg'></img><br><br>";*/

$dirpics = "../dataset/";
$dir = "dataset/test.jpg";
$src = "dataset/source.jpg";
$face1 = "dataset/face1.jpg";
$face2 = "dataset/face2.jpg";
$face3 = "dataset/face3.jpg";
$face4 = "dataset/face4.jpg";
$dest = "dataset/destination.jpg";
$namesource = "source";
$nameface1 = "face1";
$nameface2 = "face2";
$nameface3 = "face3";
$nameface4 = "face4";


$namedest = "destination";

global $rekognition;
$resize_factor = 0.5;

$name_list = array('_no_image');
echo count($name_list);
echo "<br><br>";
echo $name_list[0];
echo "<br><br>";

$parsed_rkfacevisualize = $rekognition->RkFaceVisualize($name_list , Rekognition_API::RETURN_JSON);

echo "Get response general information facevisualize:<br><br>";
var_dump($parsed_rkfacevisualize);
$links = json_decode($parsed_rkfacevisualize, TRUE);


echo "<br><br>";
$stack = array();

foreach($links['visualization']  as $item) {
	
	foreach($item['index'] as $matches) {
		
		echo "Index: " . $matches . "<br><br>";
		array_push($stack,$matches);
		/*
		echo "Image Index: " . $matches['index'] . "<br><br>";
		echo "Total Img: " . $matches['total_img'] . "<br><br>";
		*/
		
	}  
	echo "Tag: " . $item['tag'] . "<br><br>";
	echo "Total Img: " . $item['total_img'] . "<br><br>"; 
}

print_r($stack);

echo "<br><br>";

$parsed_rkfacedelete = $rekognition->RkFaceDelete($src, $stack, Rekognition_API::RETURN_JSON);
var_dump($parsed_rkfacedelete);

echo "<br><br>";

$parsed_rkfacevisualize = $rekognition->RkFaceVisualize($name_list , Rekognition_API::RETURN_JSON);

echo "Get response general information facevisualize:<br><br>";
var_dump($parsed_rkfacevisualize);

echo "<br><br>";

$parsed_rkfaceadd = $rekognition->RkFaceAdd($src, $namesource, $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);

echo "Get response general information faceadd:<br><br>";
var_dump($parsed_rkfaceadd);
$links = json_decode($parsed_rkfaceadd, TRUE);

echo "<br><br>";
foreach($links['face_detection'] as $item) {
    echo "Image Index: " . $item['img_index'] . "<br><br>";
}

$parsed_rkfaceadd = $rekognition->RkFaceAdd($face1, $nameface1 , $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);

echo "Get response general information faceadd:<br><br>";
var_dump($parsed_rkfaceadd);
$links = json_decode($parsed_rkfaceadd, TRUE);

echo "<br><br>";
foreach($links['face_detection'] as $item) {
    echo "Image Index: " . $item['img_index'] . "<br><br>";
}

$parsed_rkfaceadd = $rekognition->RkFaceAdd($face2, $nameface2 , $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);

echo "Get response general information faceadd:<br><br>";
var_dump($parsed_rkfaceadd);
$links = json_decode($parsed_rkfaceadd, TRUE);

echo "<br><br>";
foreach($links['face_detection'] as $item) {
    echo "Image Index: " . $item['img_index'] . "<br><br>";
}

$parsed_rkfaceadd = $rekognition->RkFaceAdd($face3, $nameface3 , $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);

echo "Get response general information faceadd:<br><br>";
var_dump($parsed_rkfaceadd);
$links = json_decode($parsed_rkfaceadd, TRUE);

echo "<br><br>";
foreach($links['face_detection'] as $item) {
    echo "Image Index: " . $item['img_index'] . "<br><br>";
}

$parsed_rkfaceadd = $rekognition->RkFaceAdd($face4, $nameface4 , $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);

echo "Get response general information faceadd:<br><br>";
var_dump($parsed_rkfaceadd);
$links = json_decode($parsed_rkfaceadd, TRUE);

echo "<br><br>";
foreach($links['face_detection'] as $item) {
    echo "Image Index: " . $item['img_index'] . "<br><br>";
}


$parsed_rkfacetrain = $rekognition->RkFaceTrain(Rekognition_API::RETURN_JSON);

echo "<br><br>";

$parsed_rkfacevisualize = $rekognition->RkFaceVisualize($name_list , Rekognition_API::RETURN_JSON);

echo "Get response general information facevisualize:<br><br>";
var_dump($parsed_rkfacevisualize);

echo "<br><br>";
echo "Get response general information facetrain:<br><br>";

$links = json_decode($parsed_rkfacetrain, TRUE);
var_dump($parsed_rkfacetrain);
/*
foreach($links['usage'] as $item) {
    echo $item['status'];
}
*/
echo "<br><br>";
foreach ($links as $item){
    echo "Status : " . $item['status'] . "<br><br>";
}

$parsed_rkfacesearch = $rekognition->RkFaceSearch($dest, $resize_factor, Rekognition_API::REQUEST_DIR , Rekognition_API::RETURN_JSON);


echo "<br><br>";
echo "Get response general information facesearch:<br><br>";
/*var_dump($parsed_rkfacesearch);*/
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



