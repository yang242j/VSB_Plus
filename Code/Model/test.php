<?php

$preStr = $expStr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = get_course_json(trim($_POST["short_name"]));
    $resArr = array();
    $resArr = json_decode($response);

    $preStr = $resArr->prerequisite; 
    $expStr = str2Expression($preStr);

}

function get_course_json($short_name) {
    $url = "http://15.223.123.122/vsbp/Code/Model/course.php";
    $postField = "short_name=$short_name";

    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
        CURLOPT_POSTFIELDS     => $postField, // set up post fields
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content  = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function str2Expression($preStr) {
    $pattern = "/([a-z]+\s[0-9]+)/i"; // seperate by short_name
    $wordArray = preg_split($pattern, trim($preStr), -1, PREG_SPLIT_DELIM_CAPTURE);

    echo "<pre><b>";
    print_r($wordArray);
    echo "</pre></b>";
    
    $expStr = "";
    $orFlag = false;
    foreach ($wordArray as $string) {
        if (trim($string) == "One of") {
            $orFlag = true;
            continue;
        } 
        elseif (trim($string) == "," && $orFlag == true) {
            $expStr .= " || ";
            continue;
        }
        elseif (trim($string) == ", or" && $orFlag == true) {
            $expStr .= " || ";
            $orFlag = false;
            continue;
        }

        if (trim($string) == "and") {
            $expStr .= " && ";
            continue;
        }

        if (trim($string) == "or") {
            $expStr .= " || ";
            continue;
        }

        // ignore case
        if (trim($string) == "successful completion of ") {
            continue;
        }

        $expStr .= $string;
    }

    return $expStr;
}

?>

<html>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    Name: <input type="text" name="short_name" value="<?php echo $_POST["short_name"]; ?>"><br>
    <input type="submit">
</form>

Prerequisites: <pre><mark><b><?php print_r($preStr); ?></b></mark></pre><br>
Expression: <pre><mark><b><?php print_r($expStr); ?></b></mark></pre><br>

</body>
</html>