<?php

// Include config file
require_once ('connect_members.php');


$username = $password = $confirm_password = $user_real_name = $mail_address = "";

$username_err = $password_err = $confirm_password_err = $user_real_name_err = $mail_address_err = "";

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
  if(empty(trim($_POST["user_register_id"]))){
    $username_err = "請輸入帳號";
  } else{

        // Prepare a select statement
    $sql = "SELECT id FROM members_account WHERE userid = ?";

    if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
      $param_username = trim($_POST["user_register_id"]);

            // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){

        /* store result */
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          $username_err = "此帳號已被採用!";
        } else{
          $username = trim($_POST["user_register_id"]);
        }
      } else{
        echo "抱歉...請重新再輸入一次";
      }
    }

        // Close statement
    mysqli_stmt_close($stmt);
  }
  if(empty(trim($_POST['user_register_real_name']))){
    $user_real_name_err = "請輸入姓名";
  }else{
    $user_real_name = trim($_POST['user_register_real_name']);
  }

    // Validate password
  if(empty(trim($_POST['user_reiger_password']))){
    $password_err = "請輸入密碼.";     
  } elseif(strlen(trim($_POST['user_reiger_password'])) < 6){
    $password_err = "密碼長度至少要6個以上";
  } else{
    $password = trim($_POST['user_reiger_password']);
  }

    // Validate confirm password
  if(empty(trim($_POST["register_passoword_confirmation"]))){
    $confirm_password_err = '請再次輸入密碼';     
  } else{
    $confirm_password = trim($_POST['register_passoword_confirmation']);
    if($password != $confirm_password){
      $confirm_password_err = '密碼輸入不同!';
    }
  }
  if(empty(trim($_POST['register_mail']))){
    $mail_address_err = "請輸入註冊信箱";
  }else{
    $sql_mail = "SELECT id FROM members_account WHERE mail_address = ?";
    if($stmt = mysqli_prepare($link, $sql_mail)){
      mysqli_stmt_bind_param($stmt, 's', $param_mail_address);
      $param_mail_address = trim($_POST['register_mail']);
      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==1){
          $mail_address_err = "此信箱已被採用";
        }
        else{
          $mail_address = trim($_POST['register_mail']);
        }
      }
      else{
        echo "抱歉...請重新再輸入一次";
      }

    }
    mysqli_stmt_close($stmt);
  }


    // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($user_real_name_err) && empty($mail_address_err)){

        // Prepare an insert statement
    $sql = "INSERT INTO members_account (userid, username, password, mail_address) VALUES (?, ?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $param_userid, $param_name, $param_password, $param_mail);

            // Set parameters
      $param_userid = $username;
      $param_name = $user_real_name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_mail = $mail_address;
            var_dump($param_userid);
            var_dump($param_name);
            var_dump($param_password);
            var_dump($param_mail);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page

              $sql2 = "INSERT INTO users_information (userid,username,mail_address) VALUES (?,?,?)";

              if($stmt2 = mysqli_prepare($link, $sql2)){

            // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt2, "sss", $param_userid2, $param_name2, $param_mail2);

            // Set parameters
               $param_userid2 = $username;
               $param_name2 = $user_real_name;
               $param_mail2 = $mail_address;

               var_dump($username);
               var_dump($user_real_name);
               var_dump($mail_address);
            // Attempt to execute the prepared statement
               if(mysqli_stmt_execute($stmt2)){
                // Redirect to login page
                session_start();
                $_SESSION['success'] = true;
                header("location: register_success.php");
              } else{
                echo "抱歉...請再次輸入資訊!!!!!";
              }
            }         

        // Close statement
            mysqli_stmt_close($stmt2);
          } else{
            echo "抱歉...請再次輸入資訊!!";
          }
        }         

        // Close statement
        mysqli_stmt_close($stmt);
      }


      if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($user_real_name_err) && empty($mail_address_err)){

        // Prepare an insert statement

      }
    // Close connection
    }

    ?>
    <html lang="zh-Hant">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/jquery.js"></script>

      <title>PULSER 2.0</title>

      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap.css" rel="stylesheet">
      <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

      <!--custom-css-->
      <link href="custom_css/register_css.css" rel="stylesheet">
    </head>



    <body>

      <nav class="navbar navbar-fixed-top navbar-default topnav_css" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button id="theButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="index.php"><span id="navbar_brand_span" class="fa fa-home"></span></a>
            <label class="navbar-brand">PULSER 2.0</label>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
              <li><a href="#"><label>產品</label></a></li>
              <li><a href="#"><label>應用程式</label></a></li>
              <li><a href="#"><label>說明</label></a></li>
              <li><a href="#"><label>服務</label></a></li>
              <!--<li><a href="index.php"><label class="fa fa-home"></label></a></li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right" id="navbarRight">
              <li><a href="login.php"><label>登入</label></a></li>
              <li><a id ="span1"><span class="fa fa-facebook-official"></span></a></li>
              <li><a id ="span2"><span class="fa fa-instagram"></span></a></li>
              <li><a id ="span3"><span class="fa fa-google-plus-official"></span></a></li>
            </ul>
          </div>
        </div>
      </nav>


      <div class="topnav_and_form_padding"></div>

      <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container-fluid" id="formContent">
          <div class="register_box">

            <div class="form_inside_padding"></div>

            <div class="text-center"><span id="form_title">歡迎使用PULSER 2.0</span></div>
            <div class="form_inside_padding2"></div>
            <div class="form-group" <?php echo (!empty($username)) ? 'has-error' : ''; ?>">
              <label>帳號</label><span class="emsg_userid hidden">請輸入大於6個字元</span><span class="emsg_userid2 hidden">請輸入正確的字元</span><span class="emsg_userid_empty hidden">請填入你的帳號</span><span id="emsg_userid"></span>
              <input placeholder="請輸入帳號..." class="form-control" type="text" name="user_register_id" id="userid">
              <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($user_real_name)) ? 'has-error' : ''; ?>">
              <label>姓名</label><span class="emsg_name hidden">請填入你的名字</span>
              <input placeholder="請輸入姓名..." class="form-control" type="text" name="user_register_real_name" id="name" >
              <span class="emsg hidden">請輸入正確姓名</span>
              <span class="help-block"><?php echo $user_real_name_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label>密碼</label>              
              <span class="emsg_password hidden">密碼請大於6個字元</span>
              <span class="emsg_password_empty hidden">請填入你的密碼</span>
              <input placeholder="請輸入密碼..." class="form-control" type="password" name="user_reiger_password" 
              value="<?php echo $password; ?>" id="password">
              <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
              <label>確認密碼</label>
              <span class="emsg_password_confirmation_length hidden">密碼長度不同</span>
              <span class="emsg_password_confirmation hidden">輸入的密碼不同</span>
              <span class="emsg_password_confirmation_empty hidden">請填入你的密碼確認</span>
              <input placeholder="密碼確認..." class="form-control" type="password" name="register_passoword_confirmation"
              value="<?php echo $confirm_password; ?>" id="password_confirmation">
              <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($mail_address)) ? 'has-error' : ''; ?>">
              <label>註冊信箱</label>
              <span class="emsg_mail hidden">請輸入正確的信箱格式</span>
              <span class="emsg_mail_empty hidden">請填入你的信箱</span>
              <span id="emsg_mail2"></span>
              <input placeholder="請輸入信箱..." class="form-control" type="text" name="register_mail" id="register_mail">
              <span class="help-block"><?php echo $mail_address_err; ?></span>
            </div>

            <div class="form_inside_padding4"></div>
            <div class="form_inside_padding4"></div>
            <div class="text-center">
             <input type="hidden" name="refer" value=" <?php echo (isset($_GET['refer'])) ?$_GET['refer']:'register.php';?>">
             <button id="submit_btn" type="submit" class="btn btn-info btn-lg round">註冊</button>
           </div>
           <div class="form_inside_padding3"></div>
           <div class="form-group text-center">
            <a href="login.php">已經有帳號了嗎?</a>
          </div>
          <div class="form_inside_padding3"></div>
        </div>
      </div>
    </form>
    <div class="buttom_padding"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $( document ).ready(function() {
        $('#myForm')[0].reset();
        $('input#userid').focus();
      });
    </script>
    <script>
      $(document).ready(function(){
        $('#userid').on('keypress keydwon keyup', function(){
          var validation_account = /^[a-zA-Z0-9]*$/;
          $('input#userid').removeClass('input_error');
          $('.emsg_userid_empty').addClass('hidden');
          if(((($(this).val()).length) > 6) && ($(this).val().match(validation_account))){
            $.post('account_validation.php',{account_sent: $(this).val()}, function(data){
              if(data == null){

              }else{
                document.getElementById('emsg_userid').innerHTML = data;
              }
            });
          }
          if((($(this).val()).length) <= 6){
            $('.emsg_userid').removeClass('hidden');
            $('.emsg_userid').show();
          }
          else{
            $('.emsg_userid').addClass('hidden');
          }
          if(!$(this).val().match(validation_account)){
            $('.emsg_userid2').removeClass('hidden');
            $('.emsg_userid2').show();
          }
          else{
            $('.emsg_userid2').addClass('hidden');
          }
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $('#name').on('keypress keydown keyup', function(){
          $('.emsg_name').addClass('hidden');
          $('input#name').removeClass('input_error');
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $('#password').on('keypress keydown keyup', function(){
          $('.emsg_password_empty').addClass('hidden');
          $('input#password').removeClass('input_error_password');
          if(($(this).val().length) <= 6){
            $('.emsg_password').removeClass('hidden');
            $('.emsg_password').show();
          }
          else{
            $('.emsg_password').addClass('hidden');
          } 
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $('#password_confirmation').on('keypress keydown keyup', function(){
          $('.emsg_password_confirmation_empty').addClass('hidden');
          $('input#password_confirmation').removeClass('input_error_password');
          if(($(this).val()).length == ($('#password').val()).length){
            $('.emsg_password_confirmation_length').addClass('hidden');
          }else{
            $('.emsg_password_confirmation_length').removeClass('hidden');
            $('.emsg_password_confirmation_length').show();
          }

          if( ($(this).val()) == ($('#password').val()) ){
            $('.emsg_password_confirmation').addClass('hidden');

          }else{
            $('.emsg_password_confirmation').removeClass('hidden');
            $('.emsg_password_confirmation').show();
          }
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $('#register_mail').on('keypress keydown keyup', function(){
          $('.emsg_mail_empty').addClass('hidden');
          $('input#register_mail').removeClass('input_error');
          var $validation = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
          if(!$(this).val().match($validation)){
           $('.emsg_mail').removeClass('hidden');
           $('.emsg_mail').show();
         }
         else{
          $('.emsg_mail').addClass('hidden');
          $.post('mail_validation.php',{mail_sent:$(this).val()},function(data){
            if(data==null){

            }else{
              document.getElementById('emsg_mail2').innerHTML = data;
            }
          });
        }

      });
      });
    </script>
    <script>
      $('#submit_btn').click(function(){
        var submitOK = true; 
        var validation_account = /^[a-zA-Z0-9]*$/;
        var $validation = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if($('#userid').val() == 0){
          $('.emsg_userid_empty').removeClass('hidden');
          $('.emsg_userid_empty').show();
          $('input#userid').addClass('input_error');
          submitOK = false;
        }else if((($('input#userid').val()).length) <= 6){
          $('.emsg_userid').removeClass('hidden');
          $('.emsg_userid').show();
          submitOK = false;
        }else if(!$('input#userid').val().match(validation_account)){
          $('.emsg_userid2').removeClass('hidden');
          $('.emsg_userid2').show();
          submitOK = false;
        }else if(((($('input#userid').val()).length) > 6) && ($('input#userid').val().match(validation_account))){
          $.post('account_validation.php',{account_sent: $('input#userid').val()}, function(data){
            if(data == null){
            }else{
              document.getElementById('emsg_userid').innerHTML = data;
              submitOK = false;
            }
          });
        }
        if($('input#name').val() == 0){
          $('.emsg_name').removeClass('hidden');
          $('.emsg_name').show();
          $('input#name').addClass('input_error');
          submitOK = false;
        }
        if($('input#password').val() == 0){
          $('.emsg_password_empty').removeClass('hidden');
          $('.emsg_password_empty').show();
          $('input#password').addClass('input_error_password');
          submitOK = false;
        }
        else if(($('input#password').val().length) <= 6){
         $('.emsg_password').removeClass('hidden');
         $('.emsg_password').show();
         submitOK = false;
       }
       if($('input#password_confirmation').val() == 0){
        $('.emsg_password_confirmation_empty').removeClass('hidden');
        $('.emsg_password_confirmation_empty').show();
        $('input#password_confirmation').addClass('input_error_password');
        submitOK = false;
      }else if(($('input#password_confirmation').val()).length != ($('input#password').val()).length){
        $('.emsg_password_confirmation_length').removeClass('hidden');
        $('.emsg_password_confirmation_length').show();
        submitOK = false;
      }else if(($('input#password_confirmation').val()) != ($('input#password').val())){
        $('.emsg_password_confirmation').removeClass('hidden');
        $('.emsg_password_confirmation').show();
        submitOK = false;
      }
      if($('input#register_mail').val() == 0)
      {
        $('.emsg_mail_empty').removeClass('hidden');
        $('.emsg_mail_empty').show();
        $('input#register_mail').addClass('input_error');
        submitOK = false;
      }else if(!$('input#register_mail').val().match($validation)){

       $('.emsg_mail').removeClass('hidden');
       $('.emsg_mail').show();
       submitOK = false;
     }else if($('input#register_mail').val().match($validation)){
       $.post('mail_validation.php',{mail_sent:$(this).val()},function(data){
        if(data==null){
        }else{
          document.getElementById('emsg_mail2').innerHTML = data;
          submitOK = false;
        }
      });
     }
     console.log(submitOK);
     if(!submitOK){
      $('#myForm').submit(function(){
        return false;
      });
    }

  });
</script>

</body>

<?php
mysqli_close($link);
?>
</html>
