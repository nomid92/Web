<?php
$err="";
if (isset($_POST['go'])){
	if (!isset($_POST['lat']) && strlen($_POST['lat'])<9)
		$err.='Введите правильно широту<br>';
	if (!isset($_POST['long']) && strlen($_POST['long'])<9)
		$err.='Введите правильно долготу<br>';
	if (!isset($_POST['count']) && strlen($_POST['count'])<1)
		$err.='Введите правильно количество отбора<br>';
	if (!isset($_POST['radius']) && strlen($_POST['radius'])<1)
		$err.='Введите правильно радиус<br>';
	if (!isset($_POST['start_time']) && strlen($_POST['start_time']) != 10)
		$err.='Введите правильно начальную дату<br>';
	if (!isset($_POST['end_time']) && strlen($_POST['end_time'])!=10)
		$err.='Введите правильно конечную дату<br>';
	if ($err == ""){
		$lat=$_POST['lat'];
		$long=$_POST['long'];
		$count=$_POST['count'];
		$radius=$_POST['radius'];
		$start_time=strtotime($_POST['start_time']);
		$end_time=strtotime($_POST['end_time']);
		$link="https://api.vk.com/method/photos.search?lat=".$lat."&long=".$long."&count=".$count."&radius=".$radius."&start_time=".$start_time."&end_time=".$end_time;
		//$content=file_get_contents('htapi.vk.com');
		$content=file_get_contents($link);
		//echo $content;
		$content = json_decode($content);
		$content = $content->response;
	}
}
?>
<html>
<head>
<title>Картинки с соц. сетей</title>
</head>
<body style="margin:0; padding:0;">
<div style="width: 100%;">
	<div style="width:260px; float:left; margin-left:8px">
		<form action="page1.php" method="POST">
			Введите широту: <? echo "<input type='text' name='lat' maxlength='15' value=" . $_POST['lat'] . "><br>"; ?>
			Введите долготу: <? echo "<input type='text' name='long' maxlength='15' value=" . $_POST['long'] . "><br>"; ?>
			Введите колоичество фотографий: <? echo "<input type='text' name='count' maxlength='15' value=" . $_POST['count'] . "><br>"; ?>
			Введите радиус от данной точки: <? echo "<input type='text' name='radius' maxlength='15' value=" . $_POST['radius'] . "><br>"; ?>
			Введите начальное время: <? echo "<input type='text' name='start_time' maxlength='15' value=" . $_POST['start_time'] . "><br>"; ?>
			Введите конечное время: <? echo "<input type='text' name='end_time' maxlength='15' value=" . $_POST['end_time'] . "><br>"; ?>
			<input type="submit" name="go" value="Запросить">
		</form>
	</div>
</div>
<div style="width:65%; float:right; <!--overflow:scroll;-->">
<?php
	if (count($content)>0) {
		for ($i =1 ; $i<count($content);$i++){
			echo "<a href='http://vk.com/id".$content[$i]->owner_id."'><img style=' width:300px; height:240px; float:left; margin:1px;' src='".$content[$i]->src_big."'></a>";
		}
		
	}
	else echo "данных нет!";
?>
</div>
</body>
</html>