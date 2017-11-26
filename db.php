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

$sql = "SELECT sum(count_grade)AS num_student,sex_code 
FROM public.grade_info2  
GROUP BY sex_code ORDER BY sex_code DESC";

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
    
    $labels[] = $row['sex_code'];
    $data[] = $row['num_student'];
    $sex_code[]=$row['sex_code'];
    // $labels2[]=$row['edu_year'];
    $color = generateColor();
    $bgColor[] = $color . ", 0.2)";
    $borderColor[] = $color . ", 1)";
}
  $return['data'] = $data;
  $return['labels'] = $labels;
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