<?php
//共通関数呼び出し
require('function.php');

//ログの出力、保存先を選択
error_reporting(E_ALL);
ini_set('display_errors','on');
ini_set('log_errors','on');
ini_set('error_log','php.log');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//POST送信されていた場合
if (!empty($_POST)) {
  debug('POST送信があります。');

//変数にユーザー情報を代入
$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];

//未入力チェック
validRequired($name, 'name');
validRequired($email, 'email');
validRequired($comment, 'comment');

//正しいメールアドレスかチェック
validEmail($email,'email');

//最大文字数チェック
validMaxLen($name, 'name');
validMaxLen($email, 'email');


if (empty($err_msg)) {
  debug('バリデーションチェックOKです。');

//例外処理
try {
//DBへ接続
$dbh = dbConnect();
$sql = 'INSERT INTO contact(name, email, comment, create_date, update_date) VALUES (:name, :email, :comment, :create_date, :update_date)';
$data = array(':name' => $name, ':email' => $email, ':comment' => $comment, ':create_date' => date('Y-m-d H:i:s'), ':update_date' => date('Y-m-d H:i:s'));

//クエリ実行
$stmt = queryPost($dbh, $sql, $data);

//クエリ成功の場合
  if ($stmt) {
    debug('クエリに成功しました。');
    $_POST = array();
}else {
  debug('クエリに失敗しました。');
  }
} catch (\Exception $e) {
  error_log('エラー発生:' . $e->getMessage());
    $err_msg['common'] = MSG07;
    }
  }
}

debug('画面表示終了 ####################################################');


 ?>

<?php
$pageTitle = 'トップページ';
require('head.php');
 ?>

 <?php
 require('header.php');
 ?>

<body>



<div class="site-width" style="min-height:1710px;">
  <section id="top-page" class="top-background">
    <div class="main_imgBox">
          <div class="main_img" style="background-image: url(img/DSC_0020.JPG)"></div>
          <div class="main_img" style="background-image: url(img/DSC_0281.JPG)"></div>
          <div class="main_img" style="background-image: url(img/RAIKONNEN.JPG)"></div>
          <div class="main_img" style="background-image: url(img/IMG_3822.JPG)"></div>
          <div class="main_img" style="background-image: url(img/sky1.jpg)"></div>
    </div>

  <div class="about" id="prof">
      <h1 class="profile">About</h1>
      <hr>
      <div class="profile-width">
      <img src="img/index3.jpg" alt="プロフィール写真" class="profile-photo">
      <p class="typing">
        はじめまして。Toru Murayamaと申します。神奈川県在住、30歳です。<br>
        このサイトで使用している写真はすべて私の作品で、<br>
        デザインも含めて0から作りました。
      </p>
    </div>
  </div>

  <div class="service" id="service1">
      <h1 class="skill">Service & Skill</h1>
      <div class="service-width">
        <div class="skill-head">
          <img src="img/hp.png" alt="" style="border-radius:10px;">
          <div class="skill-body">
            <h2>ホームページ制作</h2>
            <h3>ウェブ制作全般</h2>
              <p>企画から制作、運営サポートまで<br>
                  お気軽にご相談ください。
              </p>
          </div>
        </div>
        <div class="skill-head">
          <img src="img/hp2.png" alt="">
          <div class="skill-body">
            <h2 class="">WordPress</h2>
            <h3 class="">設計・デザイン</h2>
              <p>更新が必要なサイトは<br>
                  WordPressをご提案させて頂いております。
              </p>
          </div>
        </div>

        <div class="skill-head">
          <img src="img/hp3.jpg" alt="">
          <div class="skill-body">
            <h2 class="">コーポレートサイト</h2>
            <h3 class="">会社案内</h2>
              <p>会社のイメージを重視しながら、<br>
                  会社概要やお知らせの掲載、<br>
                  所在地地図の設置などに対応します。
              </p>
          </div>
        </div>

        </div>
    </div>

    <div class="contact" id="contact1">
        <h1>お問い合わせ</h1>
        <p class="request">お仕事の依頼等はこちらのフォームよりお願い致します。<br>
            1営業日以内に返信させて頂きます。
        </p>
      <div class="contact-width">
        <form class="form" method="post">

          <div class="err-msg">
            <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
          </div>

          <div class="err-msg">
            <?php if(!empty($err_msg['name'])) echo $err_msg['name']; ?>
          </div>
          <label class="<?php if(!empty($err_msg['name'])) echo 'err' ?>">
            <input type="text" name="name" value="<?php if (!empty($_POST['name'])) echo $_POST['name'];?>" placeholder="お名前を入力してください">
          </label>

          <div class="err-msg">
            <?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?>
          </div>
          <label class="<?php if(!empty($err_msg['email'])) echo 'err' ?>">
            <input type="text" name="email" value="<?php if (!empty($_POST['email'])) echo $_POST['email'];?>" placeholder="メールアドレスを入力してください">
          </label>

          <div class="err-msg">
            <?php if(!empty($err_msg['comment'])) echo $err_msg['comment']; ?>
          </div>
          <label class="<?php if(!empty($err_msg['comment'])) echo 'err' ?>">
            <textarea name="comment" rows="6" cols="105" value="<?php if (!empty($_POST['comment'])) echo $_POST['comment'];?>" placeholder="本文を入力してください" id="js-count"></textarea>
            <p class="counter-text"><span id="js-count-view">0</span>/1000文字</p>
          </label>

          <input type="submit" name="" value="送信" class="btn-submit" style="width:100px;">

        </div>


        </form>

      </div>
    </div>





  </div>

  </section>

<?php
require('footer.php');
 ?>
