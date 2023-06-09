<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<?php
$myDB = new mysqli('localhost','root','','library');
// make sure the above credentials are correct for your environment
if ($myDB->connect_error)
{
    die('Connect Error (' . $myDB->connect_error . ') ' . $myDB->connect_error);
}
$sql = "SELECT * FROM books WHERE available = 1 ORDER BY title";
$result = $myDB->query($sql);
?>

<table cellspacing="2" cellpadding="6" align="center" border="1">
    <tr>
        <td colspan="4">
            <h3 align="center">These Books are currently available</h3>
        </td>
    </tr>
    <tr>
        <td align="center">Title</td>
        <td align="center">Year Published</td>
        <td align="center">ISBN</td>
    </tr>
    <?php
    While ($row = $result->fetch_assoc() ) {
        echo "<tr>";
        echo "<td>";
        // echo stripslashes($row["title"]);
        echo stripslashes($row["title"]);
        echo "</td><td align='center'>";
        echo $row["pub_year"];
        echo "</td><td>";
        echo $row["ISBN"];
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>


</body>

</html>