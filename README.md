Squeeze
=======
###The world's squishiest URL shortener!

Demo: http://nixo.no/s

###Features:
  * Simple installation, usage and design
  * Simple requirements: Any php version, No databases, Only 3 files
  * Custom urls and auto urls
  * Easily have short urls from the root of your host without interfering
  * Same short URL for same long URL, every time

###Installation
  * Place the files in a subdirectory "s" on your root
  * OPTION 1: Add this line to your root .htaccess: ```RewriteRule ^\+(.*)$ /s?$1```
  * OPTION 2: Edit line 5 in index.php from ```'/+'``` to ```'/s?'``` This will make your short urls like ```host.com/s?aBc``` instead of ```host.com/+aBc```
  
###Usage
  * Go to domain.com/s/ to shorten a url
  * Just paste the long url and press enter to get the short url
  * Write the custom url, a space, then the long url to make a custom url. e.g. ```test http://test.com```
  * Check url.json to see the shortened urls
