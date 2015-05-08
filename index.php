<?php
  $lines = file('source/to_site.txt'); 
  $i = 0;
  $j = 0;
  $gram = '';
  while ($i <= count($lines)) {
    $hl = substr($lines[$i],0,strlen($lines[$i])-2);
    $i++;
    $sens = $lines[$i];
    $i++;
    $mas[$j] = array($hl, $sens);
    $j++;
    $i++;
  } 
  $vote= $_POST["vote"];
  $hl = $_POST["hl"];
  if (isset($vote)) {
    $file = 'source/vote.txt';
    $data = $hl.' '.$vote."\n";
    file_put_contents($file, $data, FILE_APPEND);
  }
  $head_rand = rand(1, 11);
  $img_rand = rand(1, 6);
  $rand = rand(0, count($mas)-1);
  $back_rand = rand(1, 6);
  $str[0] = 'Еще вчера это сложно было представить, но в свете сегодняшних событий, неудивительно, что эта тема оказалось на повестке дня. ';
  $str[1] = 'Стоит отметить, что существуют разные мнения по этому поводу. ';
  $str[2] = 'Издавно известно - сколько людей, столько и мнений и, возможно в другом контексте, все понималось бы по-другому. ';
  $str[3] = 'Как говорится, "кто знал, что вот так все когда-нибудь случится". ';
  $str[4] = 'В последнее время, многие СМИ предали это событие небывалой огласке, что из этого вышло, мы можем наблюдать прямо сейчас. ';
  $txt_rand1 = rand(0, 4);
  $txt_rand2 = $txt_rand1;
  while ($txt_rand2 == $txt_rand1) {
    $txt_rand2 = rand(0, 4);
  }
  $txt_rand3 = $txt_rand1;
  while ($txt_rand3 == $txt_rand2 || $txt_rand3 == $txt_rand1) {
    $txt_rand3 = rand(0, 4);
  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
  <title>
    <?php 
	  echo $mas[$rand][0];
    ?>
  </title>
  <link href="style.css" type=text/css rel=stylesheet>
  <?php echo '<style>
    .clip {
      background: url(img/back/' . $back_rand . '.jpg) repeat; 
    }
  </style>';?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
  <script type="text/javascript">
    Share = {
      vkontakte: function(purl, ptitle, pimg, text) {
          url  = 'http://vkontakte.ru/share.php?';
          url += 'url='          + encodeURIComponent(purl);
          url += '&title='       + encodeURIComponent(ptitle);
          url += '&description=' + encodeURIComponent(text);
          url += '&image='       + encodeURIComponent(pimg);
          url += '&noparse=true';
          Share.popup(url);
      },
      odnoklassniki: function(purl, text) {
          url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
          url += '&st.comments=' + encodeURIComponent(text);
          url += '&st._surl='    + encodeURIComponent(purl);
          Share.popup(url);
      },
      facebook: function(purl, ptitle, pimg, text) {
          url  = 'http://www.facebook.com/sharer.php?s=100';
          url += '&p[title]='     + encodeURIComponent(ptitle);
          url += '&p[summary]='   + encodeURIComponent(text);
          url += '&p[url]='       + encodeURIComponent(purl);
          url += '&p[images][0]=' + encodeURIComponent(pimg);
          Share.popup(url);
      },
      twitter: function(purl, ptitle) {
          url  = 'http://twitter.com/share?';
          url += 'text='      + encodeURIComponent(ptitle);
          url += '&url='      + encodeURIComponent(purl);
          url += '&counturl=' + encodeURIComponent(purl);
          Share.popup(url);
      },
      mailru: function(purl, ptitle, pimg, text) {
          url  = 'http://connect.mail.ru/share?';
          url += 'url='          + encodeURIComponent(purl);
          url += '&title='       + encodeURIComponent(ptitle);
          url += '&description=' + encodeURIComponent(text);
          url += '&imageurl='    + encodeURIComponent(pimg);
          Share.popup(url)
      },
      
      popup: function(url) {
          window.open(url,'','toolbar=0,status=0,width=626,height=436');
      }
    }; 
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".form1").slideToggle();
    });
  </script>
  <script type='text/javascript'>
    $(document).ready(function() { 
      $('input[name=answer]').change(function(){
        $('form').submit();
       });
     });
  </script>
 
  <div class="addit">
    <a class="button" onclick="$('#form2').slideToggle('slow');" href="javascript:void(0)">
      <img src="img/ico/add.png" width="28" height="28"/>
    </a>
    <font color="#747474">
       <div id="form2" style="display:none;">
         <p>Проект выполнен в рамках работы <b>"Senseless Headline Generator"</b>.
         <p><b>Бессмысленность</b> рассчитана по формуле:
         <br><br><img src="http://latex.codecogs.com/gif.latex?%5Cfrac%7B1%7D%7B%5Csum_%7Bm%3D1%7D%5E%7Bn-2%7Dm%7D%5Csum_%7Bk%3D1%7D%5E%7Bn-2%7D%5Cfrac%7Bk%5Csum_%7Bi%3D1%7D%5E%7Bn-k-1%7Dx_i%7D%7Bn-k-1%7D" />
         <br><b>n</b> – количество слов в заголовке.
         <br><b>x</b> – булева переменная, обозначающая возможность встречи (0 - возможно / 1 - невозможно) каждой из частей заголовка в реальности, путем использования результатов, возвращаемых Google Search JSON API при поиске частей заголовка, начиная с триграмм.
         <p><b>Оценка</b>, выставленная заголовку сохраняется на сервер только при нажатии кнопки "Сгенерировать".
         <p><b>Программный код</b> этого проекта и генератора можно найти на <a href="http://github.com/mmaltsev/Senseless_Headline_Generator" target="_blank">Github</a>.
       </div>
     </font>
  </div>
  
  <table><tr><td> 
    <div class = "clip">
      <div>
        <center>
          <?php echo '<img src="img/header/'. $head_rand .'.png" width="450" height="90">'; ?>
        </center>
      </div>
      <div class = "headline">
        <h1 align="center"><?php $mark[0]='?'; $mark[1]='!'; echo $mas[$rand][0].$mark[$rand % 2]; ?></h1>
      </div>
      <div class = "content">
        <?php echo '<img src="img/ill/'. $img_rand .'.jpg" width="150" height="100" align="left">'; ?>
        <?php echo $mas[$rand][0].'. '.$str[$txt_rand1].$str[$txt_rand2].$str[$txt_rand3]; ?> 
    </div>
  </td><td><form action="index.php" method="post">
      <div class="info">
        <img src="img/space.png" width="10" /><b><font size="6"><?php echo $mas[$rand][1]; ?></font></b>
        <br><img src="img/space.png" width="10" />бессмысленность
        <div id="vote">
          <p><br><img src="img/space.png" width="10" />
          <a href="#" onclick="document.getElementById('vote').innerHTML = '<p><br><br><img src=\'img/space.png\' width=\'10\' /><font color=\'#747474\'><b>Спасибо за оценку!</b></font><input type=\'hidden\' name=\'vote\' value=\'1\'><input type=\'hidden\' name=\'hl\' value=\'<?php echo $rand;?>\'><p><br>'"><img src="img/ico/smile.png" /></a>
          <img src="img/space.png" width="10" />  
          <a href="#" onclick="document.getElementById('vote').innerHTML = '<p><br><br><img src=\'img/space.png\' width=\'10\' /><font color=\'#747474\'><b>Спасибо за оценку!</b></font><input type=\'hidden\' name=\'vote\' value=\'0\'><input type=\'hidden\' name=\'hl\' value=\'<?php echo $rand;?>\'><p><br>'"><img src="img/ico/sad.png" /></a>
          <br><img src="img/space.png" width="10" />оцените заголовок
          </div>
          <p><br><img src="img/space.png" width="10" />  
          <?php echo '
            <a href="#" onclick="Share.vkontakte(\'http://mmaltsev.ru\',\''.$mas[$rand][0].'\',\'/img/ill/'.$img_rand.'.jpg\',\'Еще вчера это сложно было представить...\')"><img src="/img/ico/vk.png" height="28" width="28"></a>
            <a href="#" onclick="Share.facebook(\'http://mmaltsev.ru\',\''.$mas[$rand][0].'\',\'http://mmaltsev-ru.1gb.ru/img/ill/'.$img_rand.'.jpg\',\'Еще вчера это сложно было представить...\')"><img src="/img/ico/fb.png" height="28" width="28"></a>
            <a href="#" onclick="Share.odnoklassniki(\'http://mmaltsev.ru\',\'Еще вчера это сложно было представить...\')"><img src="/img/ico/ok.png" height="28" width="28"></a>
            <a href="#" onclick="Share.twitter(\'http://mmaltsev.ru\',\''.$mas[$rand][0].'\')"><img src="/img/ico/tw.png" height="28" width="28"></a>
          '; ?>
          <br><img src="img/space.png" width="10" />расскажите друзьям
          <p><br><img src="img/space.png" width="10" />
          <input type="submit" value="Сгенерировать" class="myButton">
          </div> </form>
  </td></tr></table>
</body>
</html>