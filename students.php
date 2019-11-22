 <?php
// 	/**
// 	 * Paramedic Station Class
// 	 add station
// 	 remove station
// 	 get station by id
// 	 get all locations with id's
// 	 */
    function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
	class Student
	{
		
// 		// constructor for the stations class
		function Student()
		{
			$this->studentid = 		"";
			$this->fullname=    "";
            $this->gender =       "";
		}

		function get($con,$studentid){
			$query = "
				select * from students
				where studentid = '$studentid'";
			$result = mysqli_query($con,$query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			$stu = new Student();
			if($row = mysqli_fetch_assoc($result)){
				$stu->studentid = $row["studentid"];
				$stu->fullname= $row["fullname"];
                $stu->gender= $row["gender"];
			}else{
				return NULL;
			}
			return $stu;

		}
		function create($con,$studentid,$fullname,$gender){ 
            $_u = new Student();
            $_u = $_u->get($con,$studentid);
            if($_u == NULL){
                
            }else{
                return -1;
            }
            $uniquestring = random_string(63);
			$query = "
				INSERT INTO 
				students (studentid, fullname, gender) 
				VALUES ('$studentid', '$fullname', '$gender');";
			$result = mysqli_query($con,$query) or die(mysql_error());
			if($result){
				$this->studentid = $studentid;
				$this->fullname = $fullname;
                $this->gender = $gender;
				return 1;
			}
			return 0;

		} 
 		

 		function getAll($con){
			$query = "select * from students";
			$result = mysqli_query($con,$query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			$all_students = array();
			while($row = mysqli_fetch_assoc($result)){
				$stu = new Student();
				$stu->studentid = $row["studentid"];
				$stu->fullname= $row["fullname"];
				$stu->gender = $row["gender"]; 
				array_push($all_students, $stu);
			}
			return $all_students;
		}

	}
 ?>