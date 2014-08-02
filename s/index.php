<?php
$host = 'http://'.$_SERVER['HTTP_HOST'].'/+';                   // change '/+' to '/s?' if you dont use .htaccess redirect
$short = $_SERVER['QUERY_STRING'];
$long = $_GET['l'];
$list = json_decode(file_get_contents('url.json'), true);
$len = 1;                                                       // initial length of new short urls


if(isset($long)){                                          // create short url
    $long=base64_decode($long);
    $split=explode(' ', $long);
    //todo: check max length, check that its an URI, give proper error
    if(sizeof($split)>1){
        $short=$split[0]; $long=$split[1]; $listed=$list[$short];
        if(isset($listed)){$long=""; $host="'".$short."' "; $short="has already been squished";}
    }else{
        $hash=base64_encode(crc32($long));
        $short = substr($hash, 0, $len);
        while(isset($listed) and $long != $listed){
            $short = substr($hash, 0, $len); $len++; $listed=$list[$short];
        }
    }
    if($long!="")file_put_contents("url.json", json_encode(array_merge($list,array ($short=>$long))));
}
else if(sizeof($short)>0 && $short!=""){                                          // go to long url, given short
    $long=$list[$short];
    if(!isset($long)){$long=" ";$host="";$short="That URL Has No Juice";}
    else{ header("Location: ".$long); exit; }
}
?>

<html>
    <head>
        <title>Squeeze</title>
        <link rel="stylesheet" type="text/css" href="style.css" title="Default" />
    </head>
    <body>
        <div class="top vcent centered">
            <div id="change" style="display:hidden;" class="small">
                <?php if(isset($long)) echo '<a class="vcent" href="'.$host.$short. '">'.$host.$short.'</a>'; ?>
                <form <?php if(isset($long)) echo 'style="display:none;"';?>
                      name="ufo" action="" class="" id="base" method="get" onsubmit="return submitform();">
                    <div class="face">&gt; &lt;</div>
                    <input id="longurl" name="l" type="text" class="innbox" />
                </form>
            </div>
        </div>
        <script type="text/javascript">
            function submitform() {
                document.ufo.l.value = btoa(document.ufo.l.value); document.ufo.submit();
            }
        </script>
    </body>
</html>