<p>Daily consensus update.</p>
<p>Last update:
<?php
	
	echo TimeAgo(filemtime('./consensus.db')).' // ';
	echo date(DATE_RFC850, filemtime('./consensus.db'));
?>
</p>

<p>Size:
<?php
	echo round(filesize('./consensus.db')/1024/1024);
?> MB
</p>

<p>Checksum MD5: <?=explode(' ', file_get_contents('./md5sum.txt'))[0]?> <a href="/md5sum.txt">md5sum.txt</a></p>
<p>Checksum SHA256: <?=explode(' ', file_get_contents('./sha256sum.txt'))[0]?> <a href="/sha256sum.txt">sha256sum.txt</a></p>

<a href="/consensus.db">https://consensus.siahub.info/consensus.db</a>

<?php 
	
	function TimeAgo($datefrom, $dateto = -1)
	{
	  if ($datefrom <= 0) {
		return "A long time ago";
	  }
	  if ($dateto == -1) {
		$dateto = time();
	  }
	  $difference = $dateto - $datefrom;
	  if ($difference < 60) {
		$interval = "s";
	  } elseif ($difference >= 60 && $difference < 60 * 60) {
		$interval = "n";
	  } elseif ($difference >= 60 * 60 && $difference < 60 * 60 * 24) {
		$interval = "h";
	  } elseif ($difference >= 60 * 60 * 24 && $difference < 60 * 60 * 24 * 7) {
		$interval = "d";
	  } elseif ($difference >= 60 * 60 * 24 * 7 && $difference < 60 * 60 * 24 * 30) {
		$interval = "ww";
	  } elseif ($difference >= 60 * 60 * 24 * 30 && $difference < 60 * 60 * 24 * 365) {
		$interval = "m";
	  } elseif ($difference >= 60 * 60 * 24 * 365) {
		$interval = "y";
	  }
	  switch ($interval) {
		case "m":
		  $months_difference = floor($difference / 60 / 60 / 24 / 29);
		  while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			$months_difference++;
		  }
		  $datediff = $months_difference;
		  if ($datediff == 12) {
			$datediff--;
		  }
		  $res = ($datediff == 1) ? "$datediff month ago" : "$datediff months ago";
		  break;
		case "y":
		  $datediff = floor($difference / 60 / 60 / 24 / 365);
		  $res = ($datediff == 1) ? "$datediff year ago" : "$datediff years ago";
		  break;
		case "d":
		  $datediff = floor($difference / 60 / 60 / 24);
		  $res = ($datediff == 1) ? "$datediff day ago" : "$datediff days ago";
		  break;
		case "ww":
		  $datediff = floor($difference / 60 / 60 / 24 / 7);
		  $res = ($datediff == 1) ? "$datediff week ago" : "$datediff weeks ago";
		  break;
		case "h":
		  $datediff = floor($difference / 60 / 60);
		  $res = ($datediff == 1) ? "$datediff hour ago" : "$datediff hours ago";
		  break;
		case "n":
		  $datediff = floor($difference / 60);
		  $res = ($datediff == 1) ? "$datediff minute ago" : "$datediff minutes ago";
		  break;
		case "s":
		  $datediff = $difference;
		  $res = ($datediff == 1) ? "$datediff second ago" : "$datediff seconds ago";
		  break;
	  }
	  return $res;
	}