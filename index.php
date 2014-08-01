<?php
    $short = $_GET['s'];
    $long = $_GET['l'];
    $list = json_decode(file_get_contents('url.json'), true);
    $host = 'http://'.$_SERVER['HTTP_HOST'].'/+';

    if(isset($short) and isset($long)){ //create custom short url
        if(!isset($list[$short]))
        file_put_contents("url.json", json_encode(array_merge($list, array ($short=>base64_decode($long)))));
        else die("Custom url already taken! Try another one.");
    }

    else if(isset($short)){ //go to long url, given short
        $long=$list[$short];
        header("Location: ".$long);
        exit;
    }

    else if(isset($long)){ //create short url given long
        $short = substr(base64_encode(dechex(crc32($long))), 0, 5);
        //$len=2;
        //while(isset($list[$short]){ $short = substr(base64_encode(dechex(crc32($long))), 0, $len); $len++;}
        $new = array ($short=>base64_decode($long));
        file_put_contents("url.json", json_encode(array_merge($list,$new)));
    }
?>

<html>
<head>
    <title>Squeeze - The world's simplest URL shortener</title>
    <link rel="stylesheet" type="text/css" href="style.css" title="Default" />
</head>
<body>
    <div class="top vcent">
        <div class="centered">
            <div id="change" style="display:hidden;" class="small">
                <?php if(isset($long)) echo '<a href="'.$host.$short. '">'.$host.$short.'</a>'; ?>

                <form <?php if(isset($long)) echo 'style="display:none;"';?>
                    name="ufo" action="" class="vcent" id="base" method="get" onsubmit="return submitform();">
                    <div class="face">&gt; &lt;</div>
                    <input id="longurl" name="l" type="text" class="innbox" />
                </form>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        function submitform() {
                document.ufo.l.value = btoa(document.ufo.l.value);
                document.ufo.submit();
        }
    </script>
    
</body>
</html>

