<?php
// Redirect if form is not submitted
if(!isset($_POST['submit'])){
    header("Location: test_index.php");
}
// The name of array that developer needs to be validated
$array_name = $_POST['array_name'];
// $code is the final printed value
$code = "<br>function name_it(";
// If array is super global don't use it as parameter for the generated function
if($array_name != "GLOBALS" && 
        $array_name != "_SERVER" && 
        $array_name != "_REQUEST" && 
        $array_name != "_POST" && 
        $array_name != "_GET" && 
        $array_name != "_FILES" && 
        $array_name != "_ENV" && 
        $array_name != "_COOKIE" && 
        $array_name != "_SESSION")
{
    $code .= "\${$array_name}";
}
$code .= "){<br>//validation of \${$array_name} array<br>";
// Unset the values that have no use anymore
unset($_POST['array_name']);
unset($_POST['submit']);
// $new_post is going to have a better structure to use it instead of $_POST
$new_post = array();
foreach($_POST as $key => $value){
    for($i=0;$i<count($_POST['index']);$i++){
        if(!isset($_POST[$key][$i])){
            $_POST[$key][$i] = "";
        }
        $new_post[$i][$key] = $_POST[$key][$i];
    }
}
// Trim the array that is going to be validated
$code .= "foreach(\${$array_name} as \$key => \$value){<br>\${$array_name}[\$key]";
$code .= "=trim(\$value);<br>}<br>";
foreach ($new_post as $key => $value) {
    // $temp is a row of form
    $temp = $new_post[$key];
    // If index is not set create a empty one to prevent variable not found error
    if(isset($temp['index']) && !empty($temp['index'])){
        $code .= "if(!isset(\${$array_name}['{$temp['index']}'])){<br>".
        "\${$array_name}['{$temp['index']}'] = '';<br>}<br>";
    }
}
$flag = FALSE;// If TRUE means a || should be used
foreach ($new_post as $key => $value) {
    // $temp is a row of form
    $temp = $new_post[$key];
    // Generate code if this index is required
    if(isset($temp['box1']) && !empty($temp['box1'])){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        //there is no need to check being set because we assigned '' to values that were not set.
        $code .= "(\${$array_name}['{$temp['index']}']=='')";
        $flag = TRUE;
    }
    //generate code if this index is Email
    if(isset($temp['box2']) && !empty($temp['box2'])){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(\${$array_name}['{$temp['index']}']!='' && !filter_var(\${$array_name}['{$temp['index']}'],"
        . "FILTER_VALIDATE_EMAIL))";
        $flag = TRUE;
    }
    //generates validation code to check if this index is numeric
    if(isset($temp['box3']) && !empty($temp['box3'])){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(\${$array_name}['{$temp['index']}']!=''&&!is_numeric(\${$array_name}['{$temp['index']}']))";
        $flag = TRUE;
    }
    //generates validattion code to check if this index is not numeric
    if(isset($temp['box4']) && !empty($temp['box4'])){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(\${$array_name}['{$temp['index']}']!=''&&is_numeric(\${$array_name}['{$temp['index']}']))";
        $flag = TRUE;
    }
    //generates validation code to check if this index is URL
    if(isset($temp['box7']) && !empty($temp['box7'])){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(\${$array_name}['{$temp['index']}']!=''&&!filter_var(\${$array_name}['{$temp['index']}'],"
        . "FILTER_VALIDATE_URL))";
        $flag = TRUE;
    }
    //generates validation code to check length
    if(isset($temp['min']) && is_numeric($temp['min']) && $temp['min'] >= 0){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(\${$array_name}['{$temp['index']}']!=''&&strlen(\${$array_name}['{$temp['index']}'])<{$temp['min']})";
        $flag = TRUE;
    }
    if(isset($temp['max']) && is_numeric($temp['max']) && $temp['max'] >= 0){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(\${$array_name}['{$temp['index']}']!=''&&strlen(\${$array_name}['{$temp['index']}'])>{$temp['max']})";
        $flag = TRUE;
    }
    // Generate validation code to check if grep matches
    if(isset($temp['grep']) && !empty($temp['grep'])){
        if($flag){$code .= " || <br>";}else{$code .= "if(<br>";}
        $code .= "(!preg_match({$temp['grep']}, \${$array_name}['{$temp['index']}']))";
        $flag = TRUE;
    }

}
if($flag){
    $code .= "<br>){<br>return false;<br>}<br>";
}
// using foreach again to change data
foreach ($new_post as $key => $value) {
    $temp = $new_post[$key];
    
    //next two are not validation, they are changing data
    
    //generates code to turn data into uppercase
    if(isset($temp['box5']) && !empty($temp['box5'])){
        $code .= "\${$array_name}['{$temp['index']}']=strtoupper(\${$array_name}['{$temp['index']}']);<br>";
    }
    
    //generates code to turn data into lowercase
    if(isset($temp['box6']) && !empty($temp['box6'])){
        $code .= "\${$array_name}['{$temp['index']}']=strtolower(\${$array_name}['{$temp['index']}']);<br>";
    }
}    
////////////////////////////////////////////////////////////////////////////////
$code .= "return \${$array_name};<br>}";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Code Generator</title>
</head>
<body style="margin-left: 20px">
    <h1>
        Function to validate the array:
    </h1>
    <h3>
        Do not forget to change the name of function
    </h3>
    
    <p style="padding:20px;border-bottom: 2px solid black; border-top: 2px solid black;">
        <?= $code ?>
    </p>
</body>
</html>

