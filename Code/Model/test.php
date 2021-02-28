<?php

$preStr = $expStr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = get_course_json($_POST["short_name"]);
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
    $chars = str_split($preStr);
    foreach ($chars as $char) {
        echo $char;
        echo "<br>";
    }
}

?>

<html>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    Name: <input type="text" name="short_name"><br>
    <input type="submit">
</form>

Prerequisites: <pre><mark><b><?php echo print_r($preStr); ?></b></mark></pre><br>
Expression: <pre><mark><b><?php echo print_r($expStr); ?></b></mark></pre><br>

</body>
</html>