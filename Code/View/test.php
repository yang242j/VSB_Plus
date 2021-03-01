<?php

$preStr = $expStr = $status = '';
$doneList = array('MATH 100', 'CHEM 104', 'CS 110', 'ENGG 100', 'MATH 110', 'ENGG 123', 'MATH 122', 'PHYS 109', 'STAT 160', 'PHYS 119', 'CS 115', 'MATH 217', 'ENEL 280', 'MATH 213');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = get_course_json(trim($_POST["short_name"]));
    $resArr = array();
    $resArr = json_decode($response);
                                        // ENGG 401
    $preStr = $resArr->prerequisite;   // One of ENEL 400, ENEV 400, ENIN 400, ENPE 400, or ENSE 400
    //$expStr = str2Expression($preStr); // ENEL 400 || ENEV 400 || ENIN 400 || ENPE 400 || ENSE 400
    $expStr = $resArr->preExpression; // ENEL 400 || ENEV 400 || ENIN 400 || ENPE 400 || ENSE 400
    //$preStr = "One of ENEL 400, ENEV 400, ENIN 400, ENPE 400, or ENSE 400";
    //$expStr = "ENEL 400 || ENEV 400 || ENIN 400 || ENPE 400 || ENSE 400";
    // $status = getStatus($expStr, $doneList); // True or False
    $status = getStatus($expStr, $doneList) ? "true" : "false";
}

function get_course_json($short_name) {
    $url = "http://15.223.123.122/vsbp/Code/Model/course.php";
    $postField = "short_name=$short_name";

    $options = array(
        CURLOPT_RETURNTRANSFER => true,       // return web page
        CURLOPT_HEADER         => false,      // don't return headers
        CURLOPT_FOLLOWLOCATION => true,       // follow redirects
        CURLOPT_MAXREDIRS      => 10,         // stop after 10 redirects
        CURLOPT_ENCODING       => "",         // handle compressed
        CURLOPT_USERAGENT      => "test",     // name of client
        CURLOPT_AUTOREFERER    => true,       // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,        // time-out on connect
        CURLOPT_TIMEOUT        => 120,        // time-out on response
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

function getStatus($expStr, $doneList) {
    // echo $expStr."<br>";
    // $expStr = "ENSE 400 || ENEL 400";
    $expStr = trim($expStr);
    // Basic: if expStr == null, return true
    if ($expStr == null) return true;
    
    // Basic: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1){
        echo in_array($expStr, $doneList) ? "<b>True</b> $expStr is in the Done array <br>" : "<b>False</b> $expStr is not in  done array <br>";
        return in_array($expStr, $doneList) ? true : false;
    }

    // $innerComp = preg_split("/[()]/i", $expStr);
    // if ($innerComp[1]) {
    //     echo "(inner)". $innerComp[1] ."<br>";
    //     return getStatus($innerComp[1], $doneList);
    // }

    // &&: split "ENSE 400 && ENEL 400" 
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1){
        foreach ($andComp as $component) {
            if ($component) {
                echo "and $component <br>";
                if (getStatus($component, $doneList) == false) return false;
            }
        }
        return true;
    }

    // Remove () if " (ENSE 400 || ENEL 400) "
    if (substr($expStr, 0, 1) == "(" && substr($expStr, -1) == ")") {
        return getStatus(substr($expStr, 1, -1), $doneList);
    }
    
    // ||: split "ENSE 400 || ENEL 400" 
    $orComp = preg_split("/(\|{2})/", $expStr);
    if (sizeof($orComp) > 1){
        foreach ($orComp as $component) {
            // echo "or $component <br>";
            if ($component) {
                echo "or $component <br>";
                if (getStatus($component, $doneList) == true) return true;
            }
        }
        return false;
    } 
    else{ echo "something error";}

}

?>

<html>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    Name: <input type="text" name="short_name" value="<?php echo $_POST["short_name"]; ?>"><br>
    <input type="submit">
</form>

Done List: <pre><mark><b><?php print_r($doneList); ?></b></mark></pre><br>
Prerequisites: <pre><mark><b><?php print_r($preStr); ?></b></mark></pre><br>
Expression: <pre><mark><b><?php print_r($expStr); ?></b></mark></pre><br>
Status: <pre><mark><b><?php print_r($status); ?></b></mark></pre><br>

</body>
</html>