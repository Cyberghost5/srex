<?php include 'include/conn.php';
session_start();
if(isset($_SESSION['admin'])){
  //header('location: admin/home');
  echo '<script>location.replace("admin/home"); </script>';
  exit;
}else
if(isset($_SESSION['user'])){

  $conn = $pdo->open();

  try{
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id'=>$_SESSION['user']]);
    $user = $stmt->fetch();
    // header('location: profile.php');
  }
  catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
  }

  $pdo->close();
}

if ('session_start()' == true) {
  $conn = $pdo->open();
  $stmt = $conn->prepare("SELECT * FROM about");
  $stmt->execute();
  $row = $stmt->fetch();
  $visitors = $row['visitors'] + 1;

  try{
    $stmt = $conn->prepare("UPDATE about SET visitors=:visitors");
    $stmt->execute(['visitors'=>$visitors]);

  }
  catch(PDOException $e){
    $_SESSION['error'] = $e->getMessage();
  }


  $pdo->close();
}

$conn = $pdo->open();

try{
  $stmt = $conn->prepare("SELECT * FROM settings WHERE id = 1");
  $stmt->execute();
  $settings = $stmt->fetch();
}
catch(PDOException $e){
  echo "There is some problem in connection: " . $e->getMessage();
}

$pdo->close();
