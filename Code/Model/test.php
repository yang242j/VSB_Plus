<?php

$preStr = $expStr = $status = '';

$doneList = [
    "CS 110" => 60,
    "MATH 103" => 70,
    "MATH 110" => 80,
];

$preStr = "CS 110 with a minimum grade of 65% and one of MATH 110 (may be taken concurrently) or MATH 103 with a minimum grade of 80%.";
//$expStr = "CS 110 && ( MATH 110 || MATH 103 )";
$expStr = "CS 110 [>= 65] && ( MATH 110 || MATH 103 [>= 80] )";

$status = exp_matched($expStr, $doneList) ? "True" : "False";

function exp_matched($expStr, $doneList) {
    $expStr = trim($expStr);

    // Basic: if expStr == null, return true
    if ($expStr == null) {
        return true;
    }

    // Basic: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1) {
        return array_key_exists($expStr, $doneList) ? true : false;
    }

    // Basic: exact one course name with grade req "ENSE 400 [>= 60]"
    if (preg_match_all("/([a-z]+\s[0-9]+\s\[(.*?)\])/i", $expStr) == 1) {
        echo $expStr;
        $splitedStr = preg_split("/(\s\[)/i", $input_line);
        echo $splitedStr;
        if (array_key_exists($splitedStr[0], $doneList)) {
            $gradeExp = rtrim($splitedStr[1], ']');
            echo $gradeExp;
            if (eval('return ' . $doneList[$splitedStr[0]] . $gradeExp . ';')) {
                return true;
            } else {
                return false;
            }
        }
    }

    // &&: split "ENSE 400 && ENEL 400"
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1) {
        foreach ($andComp as $component) {
            if ($component) {
                echo "and $component <br>";
                if (exp_matched($component, $doneList) == false) {
                    return false;
                }
            }
        }
        return true;
    }

    // Remove () if " (ENSE 400 || ENEL 400) "
    if (substr($expStr, 0, 1) == "(" && substr($expStr, -1) == ")") {
        return exp_matched(substr($expStr, 1, -1), $doneList);
    }

    // ||: split "ENSE 400 || ENEL 400"
    $orComp = preg_split("/(\|{2})/", $expStr);
    if (sizeof($orComp) > 1) {
        foreach ($orComp as $component) {
            //echo "or $component <br>";
            if ($component) {
                echo "or $component <br>";
                if (exp_matched($component, $doneList) == true) {
                    return true;
                }
            }
        }
        return false;
    } else {
        echo "something error";
    }

}

?>

<html>
<body>

<h1> CS 115 </h1>

Done List: <pre><mark><b><?php print_r($doneList); ?></b></mark></pre><br>
Prerequisites: <pre><mark><b><?php print_r($preStr); ?></b></mark></pre><br>
Expression: <pre><mark><b><?php print_r($expStr); ?></b></mark></pre><br>
Status: <pre><mark><b><?php print_r($status); ?></b></mark></pre><br>

</body>
</html>