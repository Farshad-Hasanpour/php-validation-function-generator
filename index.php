<!DOCTYPE html>
<?php
const NUMBER_OF_INDEXES = 10;
$address = 'array_validator.php';
?>
<html>
    <head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
        <style type="text/css">
        	body{
        		padding-top: 20px;
        		padding-bottom: 50px;
                background-color: whitesmoke;
        	}
        	table, th, td{
        		text-align: center;
        	}
        	tbody>tr:hover{
        		background-color: white;
        	}
        	.table{
        		margin-top: 15px;
        	}
        	.form-group{
        		margin-bottom: 0;
        	}
        	input[type=checkbox]{
        		margin-top: 10px;
        	}
            #describtion{
                font-size: 18px;
            }
            .min, .max{
                width: 100px;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <h2>Array Validation</h2>
            <p id='describtion'>
                Enter the name of array you want to validate, indexes of array and fill the conditions then hit the generate button. Copy and paste the generated function in your PHP code in order to use it.  Please consider to not enter $ character in the array name. Global variables can be used too.
            </p>
            <form name="generator" method="POST" action="<?= $address ?>">
            	<div class="alert alert-info">
                    (=) Means length is same as the input.
                </div>
                <div class="alert alert-danger">
                    Be carefull about conflicts. for example a value may not be both Email and URL, conflicts may cause impalpable problems
                </div>
                <div class="alert alert-danger">
                    Do not leave all indexes or conditions empty
                </div>
                <div style="width: 30%;">
                	<div class="input-group">
                		<div class="input-group-addon">$</div>
                		<input required type="text" name="array_name" class="form-control" placeholder="array name...">
                	</div>
                </div>
            	<table class="table">
            		<thead>
            			<tr>
            				<th>Number</th>
            				<th>Index</th>
            				<th>Required</th>
            				<th>Email</th>
            				<th>Numeric</th>
            				<th>Not Numeric</th>
            				<th>to upper case</th>
            				<th>to lower case</th>
            				<th>URL</th>
            				<th>min length<span style="color:red;">(=)</span></th>
            				<th>max length<span style="color:red;">(=)</span></th>
            				<th>Regex</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php for($i=0;$i<NUMBER_OF_INDEXES;$i++){ ?>
            			<tr>
            				<td class="number">
            					<?php echo "$i"?>
            				</td>
            				<td class="index">
            					<div class="form-group">
            						<input type="text" class="form-control" name="index<?php echo "[$i]"?>" placeholder="index<?php echo $i?>...">
            					</div>
            				</td>
            				<td class="required">
            						<input type="checkbox" name="box1<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="email">
            						<input type="checkbox" name="box2<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="numeric">
            					<input type="checkbox" name="box3<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="not_numeric">
            					<input type="checkbox" name="box4<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="upper_case">
            					<input type="checkbox" name="box5<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="lower_case">
            					<input type="checkbox" name="box6<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="URL">
            					<input type="checkbox" name="box7<?php echo "[$i]"?>" value="1">
            				</td>
            				<td class="min">
            					<div class="form-group">
            						<input type="number" class="form-control" name="min<?php echo "[$i]"?>">
            					</div>
            				</td>
            				<td class="max">
            					<div class="form-group">
            						<input type="number" class="form-control" name="max<?php echo "[$i]"?>">
            					</div>
            				</td>
            				<td class="regex">
            					<div class="form-group">
            						<input type="text" class="form-control" name="grep<?php echo "[$i]"?>">
            					</div>
            				</td>
            			</tr>
            			<?php } ?>
            		</tbody>
            	</table>
                <input type="submit" class="btn btn-primary" name="submit" value="Generate PHP function">
            </form>
        </div>
    </body>

    <!-- scripts -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</html>
