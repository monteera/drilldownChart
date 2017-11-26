<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Max-Age: 1000');
header('Content-Type: application/json; charset=utf-8');
 
$conn = pg_connect("host=localhost port=5432 dbname=student_new user=postgres password=5710210326");

if(!$conn){
  echo"An error occurred.\n";
  exit;
}

$sql = "SELECT dept_id,department_name_thai,sum(count_grade)AS num_student,sex_code
FROM public.grade_info2  
WHERE sex_code='".$_POST['sex_code']."'
GROUP BY sex_code,dept_id,department_name_thai ORDER BY dept_id,sex_code DESC;";

// $sql="SELECT sum(count_grade)AS num_student,edu_year FROM public.grade_info  
// GROUP BY edu_year ORDER BY edu_year DESC";

$result = pg_query($conn,$sql);


if(!$result){

  echo"An error occurred.\n";
  exit;
 }
//pg_fetch_row ดึงข้อมูลหนึ่งแถวจากผลลัพธ์ที่เกี่ยวข้องกับตัวแฟรresource

//$data = array();

while($row = pg_fetch_assoc($result)){
  //echo "subject_id:$row[0] edu_year:$row[1]";
  //echo"<br />\n";
  //($data, $row);

  //$buffer = '';
    
    $labels[] = $row['department_name_thai'];
    $data[] = $row['num_student'];
    $dept_id[] = $row['dept_id'];
    // $edu_year[] = $row['edu_year'];
    // $labels2[]=$row['edu_year'];
    $text[]=$row['sex_code'];
    $sex_code[]=$row['sex_code'];
    $color = generateColor();
    $bgColor[] = $color . ", 0.2)";
    $borderColor[] = $color . ", 1)";
}
  // $return['edu_year'] = $edu_year;
  $return['labels'] = $labels;
  $return['text'] = $text;
  $return['data'] = $data;
  $return['dept_id'] = $dept_id;
  $return['sex_code'] = $sex_code;
  $return['backgroundColor'] =$bgColor;
  $return['borderColor'] =$borderColor;

  echo json_encode($return,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

  function generateColor(){

  return 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255);

  }

//echo json_encode($data);
//echo json_encode($labels);

?>