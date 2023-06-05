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
    $sinhvien = array(
        array("ten"=> "QUY", "tuoi" => "18", "diem"=>60),
        array("ten"=> "Vinh", "tuoi" => "10", "diem"=>12),
        array("ten"=> "Huy", "tuoi" => "20", "diem"=>30),
        array("ten"=> "Hoa", "tuoi" => "18", "diem"=>40)
    );
    foreach($sinhvien as $item){
        $diem = $item["diem"];
        if($diem >= 40){
            echo"cac sinh vien do: " . "<br>";
            echo"Ten: ". $item["ten"]. ",". "Tuoi" .$item["tuoi"] . "," . "Diem" . $item["diem"] . "<br>";
        }else{
            echo"cac sinh vien truot: " . "<br>";
            echo"Ten: ". $item["ten"]. ",". "Tuoi" .$item["tuoi"] . "," . "Diem" . $item["diem"] . "<br>";

        };
    }

    ?>
 
</body>

</html>