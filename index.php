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

<p>Checksum SHA256: <?=explode(' ', file_get_contents('./sha256sum.txt'))[0]?> <a href="/sha256sum.txt">sha256sum.txt</a></p>

<p>Download: <a href="/consensus.db">https://consensus.siahub.info/consensus.db</a> (proxy CloudFlare)</p>
<p>Download mirror: <a href="http://direct.consensus.siahub.info/consensus.db">http://direct.consensus.siahub.info/consensus.db</a> (directly from server)</p>

<p>How to: <a href="https://forum.sia.tech/topic/155/consensus-db-downloads">https://forum.sia.tech/topic/155/consensus-db-downloads</a></p>
<p>How to 2: <a href="https://siawiki.tech/daemon/bootstrapping_the_blockchain">https://siawiki.tech/daemon/bootstrapping_the_blockchain</a></p>

<p><a href="https://github.com/S-anasol/consensus.siahub.info"><svg aria-hidden="true" class="octicon octicon-mark-github" height="24" version="1.1" viewBox="0 0 16 16" width="24"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg></a></p>

<?php
    /**
     * @link https://gist.github.com/jblyberg/1572386
     *
     */
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
