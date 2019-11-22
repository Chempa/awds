<?php
include("db.php");
include("students.php");

$number_of_females = 0;
$number_of_males = 0;
$number_of_student = 0;
$all_students = [];
$_studentid = "";

$_ = new Student();
if(isset($_GET["download"])){
    $all_students = $_->getAll($con);
    $data = "Studend_ID,Fullname,Gender\n";
    for ($i=0; $i < count($all_students); $i++) { 
        $__ = $all_students[$i];
        $line = $__->studentid.",".$__->fullname.",".$__->gender."\n";
        $data = $data . $line;
    } 
    header('Content-Disposition: attachment; filename="file.csv"');
    header('Content-Type: text/plain'); # Don't use application/force-download - it's not a real MIME type, and the Content-Disposition header is sufficient
    header('Content-Length: ' . strlen($data));
    header('Connection: close');
    echo $data;
    exit();
}

if (isset($_POST['fullname'])) { 
    $_studentid = $_POST["studentid"];
    $_fullname = $_POST["fullname"];
    $_gender = $_POST["gender"];
    $_studentid = strtolower($_studentid);
    $ret = $_->create($con,$_studentid,$_fullname,$_gender);
    if($ret == 1){

    }else{

    } 
} else  { 
}
 
$all_students = $_->getAll($con);
$number_of_student = count($all_students);

for ($i=0; $i < count($all_students); $i++) { 
    if($all_students[$i]->gender == "male"){ 
        $number_of_males += 1;
    }else{
        $number_of_females += 1;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script type="text/javascript" src="./jquery.js"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <img src="./logo.png" id="logo">
            </div>
            <div class="col-12">
                <h3 id='title'>Socialization Attendants</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="./index.php#new_user" class="was-validated" method="post">

                    <div class="form-group">
                        <label for="uname">Student ID</label>
                        <input type="text" class="form-control" id="uname" placeholder="Enter student id" name="studentid" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Fullname:</label>
                        <input type="text" class="form-control" id="pwd" placeholder="Enter fullname" name="fullname" required>
                    </div>
                    <div class="form-group" id="btn-container">
                    	<label for="pwd">Gender:</label>
                        <div class="form-check mb-2 mr-sm-2">
                            <label class="form-check-label">
                                <input class="form-check-input" name="gender" value="male" type="radio" required> Male
                            </label>
                            <label class="form-check-label ml-2">
                                <input class="form-check-input" name="gender" value="female" type="radio" required> Female
                            </label>
                        </div> 
                    </div>
                    <div class="form-group" id="btn-container">
                        <button id="submit-btn" type="submit" class="btn btn-info">Submit</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="mycard" class="card">
                    <div class="card-body">
                        <h5 class="card-title">Summary</h5>
                        <p class="card-text">Number of Students: <span class="badge badge-info float-right"><?php echo $number_of_student; ?></span></p>
                        <p class="card-text">Males: <span class="badge badge-info float-right"><?php echo $number_of_males; ?></span></p>
                        <p class="card-text">Females: <span class="badge badge-info float-right"><?php echo $number_of_females; ?></span></p>
                        <a href="./index.php?download=1" class="btn btn-info">Download List</a>
                    </div>
                </div>
                <h5 id="listtitle">Registered Students</h5>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Fullname</th>
                            <th>Student ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i=0; $i < count($all_students); $i++) { 
                            $stu = $all_students[$i]; 
                        ?>

                            <?php
                            if ($_studentid == $all_students[$i]->studentid) {
                            ?>
                            <tr id="new_user" style="background-color:lightgrey">
                                <td><?php echo ucwords(strtolower($stu->fullname)); ?></td>
                                <td><?php echo strtoupper($stu->studentid); ?></td>
                            </tr>  
                            <?php
                            }else{
                            ?>
                            <tr>
                                <td><?php echo ucwords(strtolower($stu->fullname)); ?></td>
                                <td><?php echo strtoupper($stu->studentid); ?></td>
                            </tr> 
                            <?php
                            }
                            ?> 

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center">Designed By: Chempa<br>email:<a href="mailto:francis.chempa@stu.ucc.edu.gh">francis.chempa@stu.ucc.edu.gh</a></p>
</body>

</html>
