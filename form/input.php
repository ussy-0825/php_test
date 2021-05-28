<?php 

session_start();

require 'validation.php';

header('X-FRAME-OPTIONS:DENY');

// スーパーグローバル変数 php 9種類
// 連想配列
if(!empty($_POST)){
  echo '<pre>';
  var_dump($_POST);
  echo '</pre>';
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 入力、確認、完了
$pageFlag = 0;
$errors = validation($_POST);

if(!empty($_POST['btn_confirm']) && empty($errors)){
  $pageFlag = 1;
}

if(!empty($_POST['btn_submit'])){
  $pageFlag = 2;
}

?>

<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Hallo.world</title>
  </head>
<body>

<?php if($pageFlag === 1) :?>
<?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>

確認画面
<form method="POST" action="input.php">
氏名
<?php echo h($_POST['your_name']); ?>
<br>
メールアドレス
<?php echo h($_POST['email']); ?>
<br>
ホームページ
<?php echo h($_POST['url']); ?>
<br>
性別
<?php
  if($_POST['gender'] === '1'){ echo '男性';}
  if($_POST['gender'] === '2'){ echo '女性';}
?>
<br>
年齢
<?php
  if($_POST['age'] === '1'){ echo '〜19歳' ;}
  if($_POST['age'] === '2'){ echo '20〜29歳' ;}
  if($_POST['age'] === '3'){ echo '30〜39歳' ;}
  if($_POST['age'] === '4'){ echo '40〜49歳' ;}
  if($_POST['age'] === '5'){ echo '50〜59歳' ;}
  if($_POST['age'] === '6'){ echo '60歳〜' ;}
?>
<br>
お問い合わせ内容
<?php echo h($_POST['contact']); ?>
<br>
<input type="submit" name="back" value="戻る">
<input type="submit" name="btn_submit" value="送信する">
<input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
<input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
<input type="hidden" name="url" value="<?php echo h($_POST['url']); ?>">
<input type="hidden" name="gender" value="<?php echo h($_POST['gender']); ?>">
<input type="hidden" name="age" value="<?php echo h($_POST['age']); ?>">
<input type="hidden" name="contact" value="<?php echo h($_POST['contact']); ?>">
<input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']); ?>">
</form>

<?php endif; ?>
<?php endif; ?>


<?php if($pageFlag === 2): ?>
<?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>
送信が完了しました

<?php unset($_SESSION['csrfToken']); ?>
<?php endif ;?>
<?php endif; ?>


<?php if($pageFlag === 0): ?>
<?php
  if(!isset($_SESSION['csfToken'])){
  $csrfToken = bin2hex(random_bytes(32));
  $_SESSION['csrfToken'] = $csrfToken;
  }
  $token = $_SESSION['csrfToken'];
?>

<?php if(!empty($errors) && !empty($_POST['btn_confirm'])) : ?>
<?php echo '<ul>' ;?>
<?php
  foreach($errors as $error){
    echo '<li>'. $error . '</li>' ;
  }
?>
<?php echo '</ul>' ;?>
<?php endif ;?>

入力画面
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="input.php">
      <div class="form-group">
        <label for="your_name">氏名</label>
        <input type="text" class="form-control" id="your_name" name="your_name" value="<?php if(!empty($_POST['your_name'])){ echo h($_POST['your_name']);} ?>" required>
      </div>

      <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php if(!empty($_POST['email'])){ echo h($_POST['email']);} ?>" required>
      </div>

      <div class="form-group">
        <label for="url">ホームページ</label>
        <input type="url" class="form-control" id="url" name="url" value="<?php if(!empty($_POST['url'])){ echo h($_POST['url']);} ?>">
      </div>

      性別
      <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="gender" id="gender1" value="1"
        <?php if(!empty($_POST['gender']) && $_POST['gender'] === '1' )
        {echo 'checked'; }?>>
        <label class="form-check-label" for="gender1">男性</label>
      </div>

      <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="gender" id="gender2" value="2"
        <?php if(!empty($_POST['gender']) && $_POST['gender'] === '2' )
        {echo 'checked'; }?>>
        <label class="form-check-label" for="gender2">女性</label>
      </div>

      <div class="form-group">
      <label for="age">年齢</label>
      <select class="form-control" id="age" name="age">
        <option value="">選択してください</option>
        <option value="1" 
          <?php if(!empty($_POST['age']) && $_POST['age'] === '1' )
          {echo 'selected'; }?>>〜19歳
        </option>
        <option value="2"
          <?php if(!empty($_POST['age']) && $_POST['age'] === '2' )
          {echo 'selected'; }?>>20〜29歳
        </option>
        <option value="3"
          <?php if(!empty($_POST['age']) && $_POST['age'] === '3' )
          {echo 'selected'; }?>>30〜39歳
        </option>
        <option value="4"
          <?php if(!empty($_POST['age']) && $_POST['age'] === '4' )
          {echo 'selected'; }?>>40〜49歳
        </option>
        <option value="5"
          <?php if(!empty($_POST['age']) && $_POST['age'] === '5' )
          {echo 'selected'; }?>>50〜59歳
        </option>
        <option value="6"
          <?php if(!empty($_POST['age']) && $_POST['age'] === '6' )
          {echo 'selected'; }?>>60歳〜
        </option>
      </select>
      </div>

      <div class="form-group">
        <label for="contact">お問い合わせ内容</label>
        <textarea class="form-control" id="contact" row="3" name="contact">
        <?php if(!empty($_POST['contact'])){ echo h($_POST['contact']);} ?>
        </textarea>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="caution" name="caution" value="1">
        <label for="caution">注意事項のチェックする</label>
      </div>

      <input class="btn btn-info" type="submit" name="btn_confirm" value="確認する">
      <input type="hidden" name="csrf" value="<?php echo $token; ?>">
      </form>

    </div><!-- .col-md-6 -->
  </div>
</div>


<?php endif; ?>



<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
   
  </body>
</html>