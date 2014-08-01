<?php
    $short = $_GET['s'];
    $long = $_GET['l'];
    $list = json_decode(file_get_contents('url.json'), true);
    $host = 'http://'.$_SERVER['HTTP_HOST'].'/+';

    if(isset($short)){
        $long=$list[$short];
        header("Location: ".$long);
        exit;
    }
    else if(isset($long)){
        $short = substr(base64_encode(dechex(crc32($long))), 0, 5);
        $new = array ($short=>base64_decode($long));
        //todo: check if taken, make new, make longer, start shorter.
        file_put_contents("url.json", json_encode(array_merge($list,$new)));
    }
?>

<html>
<head>
    <title>/S/</title>
    <link rel="stylesheet" type="text/css" href="style.css" title="Default" />
</head>
<body>
    <div class="top">
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

