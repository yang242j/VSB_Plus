<?php

$preStr = $expStr = $status = '';

$doneList = array('MATH 100', 'CHEM 104', 'CS 110', 'ENGG 100', 'MATH 110', 'ENGG 123', 'MATH 122', 'PHYS 109', 'STAT 160', 'PHYS 119', 'CS 115', 'MATH 217', 'ENEL 280', 'MATH 213');

$preStr = "CS 110 with a minimum grade of 65% and one of MATH 110 (may be taken concurrently) or MATH 103 with a minimum grade of 80%.";
$expStr = "CS 110 [>= 65] && ( MATH 110 || MATH 103 [>= 80] )";

$status = exp_matched($expStr, $doneList) ? "true" : "false";

function exp_matched($expStr, $doneList) {
    $expStr = trim($expStr);

    // Basic: if expStr == null, return true
    if ($expStr == null) {
        return true;
    }

    // Basic: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1) {
        //echo in_array($expStr, $doneList) ? "<b>True</b> $expStr is in the Done array <br>" : "<b>False</b> $expStr is not in  done array <br>";
        return in_array($expStr, $doneList) ? true : false;
    }

    // &&: split "ENSE 400 && ENEL 400"
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1) {
        foreach ($andComp as $component) {
            if ($component) {
                //echo "and $component <br>";
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
            // echo "or $component <br>";
            if ($component) {
                //echo "or $component <br>";
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