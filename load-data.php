<?php
    // include ('db.php');

    // $sql = "SELECT * FROM timer";
    // $result = mysqli_query($conn, $sql);

    //     if(mysqli_num_rows($result) > 0) {
    //        $data   =   mysqli_fetch_all($result,MYSQLI_ASSOC);
    //        echo json_encode($data);
    //    }       
 ?>

<?php
include ('db.php');
$db=$conn;
// fetch query
function fetch_data(){
 global $db;
  $query="SELECT * from timer ORDER BY id DESC";
  $exec=mysqli_query($db, $query);
  if(mysqli_num_rows($exec)>0){
    $row= mysqli_fetch_all($exec, MYSQLI_ASSOC);
    return $row;  
        
  }else{
    return $row=[];
  }
}
$fetchData= fetch_data();
show_data($fetchData);
function show_data($fetchData){
//  echo '<table border="1">
//         <tr>
//             <th>S.N</th>
//             <th>Full Name</th>
//         </tr>';
 if(count($fetchData)>0){
      $sn=1;
      foreach($fetchData as $data){ 
  echo "<tr>
          <td>".$sn."</td>
          <td>".$data['name']."</td>
          <td>".$data['time']."</td>
   </tr>";
       
  $sn++; 
     }
}else{
     
  echo "<tr>
        <td colspan='7'>No Data Found</td>
       </tr>"; 
}
  echo "</table>";
}
?>