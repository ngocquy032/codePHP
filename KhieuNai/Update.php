<?php
//Include config file
require_once 'config.php';

//Define variables and initialize with empty values
$name = $sdt = $liDo = "";
$name_err = $sdt_err = $liDo_err = "";

//Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    //Get hidden input value
    $id = $_POST["id"];

    //Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    }elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        
        $name_err = 'Please enter a valid name.';
    }else{
        $name = $input_name;
    }

    //Validate address 
    $input_liDo = trim($_POST["liDo"]);
    if(empty($input_liDo)){
        $liDo_err = 'Please enter an Li do.';
    }else{
        $liDo = $input_liDo;
    }

    //Validate sdt
    $input_sdt = trim($_POST["sdt"]);
    if(empty($input_sdt)){
        $sdt_err = "Please enter the sdt amount.";
    }elseif(!ctype_digit($input_sdt)){
        $sdt_err = 'Please enter a positive integer value.';
    }else{
        $sdt = $input_sdt;
    }

    //Check input errors before inserting in database
    if(empty($name_err) && empty($sdt_err) && empty($liDo_err)){
        //Prepare an insert statement
        $sql = "UPDATE khieunai SET name=?, sdt=?, liDo=? WHERE id=?";

        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt,"sssi",$param_name, $param_sdt, $param_liDo,$param_id);

            //Set parameters
            $param_name = $name;
            $param_sdt = $sdt;
            $param_liDo = $liDo;
            $param_id = $id;


            //Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                //Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            }else{
                echo "Something went wrong. Please try again later.";
            }
        }
        //Close statement
        mysqli_stmt_close($stmt);
    }
    //Close connection
    mysqli_close($conn);
}else{
    //Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        //Get URL parameter
        $id = trim($_GET["id"]);

        //Prepare a select statement 
        $sql ="SELECT * FROM khieunai WHERE id=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $name = $row["name"];
                    $sdt = $row["sdt"];
                    $liDo = $row["liDo"];
                }else{
                    header("location: error.php");
                    exit();
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        //Close statement
        mysqli_stmt_close($stmt);

        //Close connection
        mysqli_close($conn);
    }else{
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo(!empty($sdt_err)) ? 'has-error' : ''; ?>">
                            <label>SĐT</label>
                            <textarea name="sdt" class="form-control"><?php echo $sdt; ?></textarea>
                            <span class="help-block"><?php echo $sdt_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($liDo_err)) ? 'has-error' : ''; ?>">
                            <label>LiDo</label>
                            <input type="text" name="liDo" class="form-control" value="<?php echo $liDo; ?>">
                            <span class="help-block"><?php echo $liDo_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>