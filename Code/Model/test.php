<?php

$preStr = $expStr = $status = '';

$totalCredit = 30;

$doneList = [
    "CS 110" => 70,
    "MATH 103" => 70,
    // "MATH 110" => 50,
    "ECON 100" => 50,
    "Pre-Calculus 20" => 50,
];

$preStr = "15 credit hours or ECON 100 or Pre-Calculus 20 (or equivalent)";
$expStr = "Credit [>= 15] || ECON 100 || Pre-Calculus 20";
// $expStr = "CS 110 && ( MATH 110 || MATH 103 )";
// $expStr = "CS 110 [>= 65] && ( MATH 110 || MATH 103 [>= 80] )";

$status = exp_matched($expStr, $totalCredit, $doneList) ? "True" : "False";

function exp_matched($expStr, $totalCredit, $doneList) {
    $expStr = trim($expStr);

    // Base case: if expStr == null, return true
    if ($expStr == null) {
        return true;
    }

    // Base case: Pending credit requirements
    if (preg_match_all("/^(Credit\s\[(.*?)\])$/i", $expStr) == 1) {
        echo "expStr: " . $expStr . "<br>";
        $creditStr = preg_split("/(\s\[)/i", $expStr);
        $creditExp = rtrim($creditStr[1], ']');
        if (eval('return ' . $totalCredit . $creditExp . ';')) {
            echo "Truee1 <br>";
            return true;
        } else {
            echo "Falsee1 <br>";
            return false;
        }
    }

    // Base case: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1) {
        // Check if has condition
        if (preg_match_all("/([a-z]+\s[0-9]+\s\[(.*?)\])/i", $expStr) == 1) {
            echo "expStr: $expStr <br>";
            $splitedStr = preg_split("/(\s\[)/i", $expStr);
            echo "splitedStr: ".$splitedStr[0]." \ ".$splitedStr[1]."<br>";
            if (array_key_exists($splitedStr[0], $doneList)) {
                $gradeExp = rtrim($splitedStr[1], ']');
                echo "gradeExp: $gradeExp <br>";
                echo "courseGrade: ".$doneList[$splitedStr[0]]."<br>";
                if (eval('return ' . $doneList[$splitedStr[0]] . $gradeExp . ';')) {
                    echo "Truee <br>";
                    return true;
                } else {
                    echo "Falsee <br>";
                    return false;
                }
            }
        }
        echo "No condition <br>";
        return array_key_exists($expStr, $doneList) ? true : false;
    }

    // &&: split "ENSE 400 && ENEL 400"
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1) {
        foreach ($andComp as $component) {
            if ($component) {
                echo "and $component <br>";
                if (exp_matched($component, $totalCredit, $doneList) == false) {
                    return false;
                }
            }
        }
        return true;
    }

    // Remove () if " (ENSE 400 || ENEL 400) "
    if (substr($expStr, 0, 1) == "(" && substr($expStr, -1) == ")") {
        return exp_matched(substr($expStr, 1, -1), $totalCredit, $doneList);
    }

    // ||: split "ENSE 400 || ENEL 400"
    $orComp = preg_split("/(\|{2})/", $expStr);
    if (sizeof($orComp) > 1) {
        foreach ($orComp as $component) {
            //echo "or $component <br>";
            if ($component) {
                echo "or $component <br>";
                if (exp_matched($component, $totalCredit, $doneList) == true) {
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

<h1> ECO 201 </h1>

Done List: <pre><mark><b><?php print_r($doneList); ?></b></mark></pre><br>
Prerequisites: <pre><mark><b><?php print_r($preStr); ?></b></mark></pre><br>
Expression: <pre><mark><b><?php print_r($expStr); ?></b></mark></pre><br>
Status: <pre><mark><b><?php print_r($status); ?></b></mark></pre><br>

</body>
</html>