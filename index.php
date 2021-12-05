<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <title>Теми магістерських робіт</title>
         <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
         <link rel="stylesheet" href="styles.css">
         <script src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
         <script src="//code.jivosite.com/widget/Dylno1zhF7" async></script>
         <script>
            var isAllCheck = true;
            var btn_txt = "×";
            var btn_fontsize = '12.5px';
            function togglecheckboxes(cn){
            
                var cbarray = document.getElementsByName(cn);
                for(var i = 0; i < cbarray.length; i++)
                {
            
                    cbarray[i].checked = !isAllCheck
                }
                
                btn_txt = (btn_txt == "×") ? "✔" : "×";
                $('.btn-small').val(btn_txt);
                btn_fontsize = (btn_fontsize == "12.5px") ? "12.1px" : "12.5px";
                $('.btn-small').css('font-size', btn_fontsize);
                isAllCheck = !isAllCheck;   
            }
        </script>
    </head>
    <body>
    <header class="index">
        <h1>Теми випускних кваліфікаційних проєктів (робіт) за другим (магістерським) освітнім рівнем</h1>
        <form method="get" action="/workcheck.php">
          <div class="worktitle-filter">
              <input type="text" placeholder="Введіть тему роботи або пошукові ключі..." name="worktitle">
              <input type="submit" class="btn" name="submit" value="Пошук">
          </div>
        <div class="sensitivity-filter">
            <b>Мінімальний збіг:</b>
            <label for="sens1">
            <input type="radio" id="sens1" name="sensitivity" value="1" />будь-яке слово 
            </label>
            <label for="sens2">
            <input type="radio" id="sens2" name="sensitivity" value="2" checked/>два
            </label>
            <label for="sens3">
            <input type="radio" id="sens3" name="sensitivity" value="3" />три 
            </label>
            <label for="sens4">
            <input type="radio" id="sens4" name="sensitivity" value="100" />усі 
            </label>
        </div>
        <div class="supervisor-filter">
            <p><b>Прізвище керівника:</b></p>
            <input type="text" placeholder="Введіть одне або кілька прізвищ..." name="supervisor">
        </div>
        <div class="institution-filter">
            <label for="Institution"><p><b>Навчальний підрозділ:</b></p>
              <select name="institution" id="Institution">
                <option value="" selected> -- Обрати варіант --</option>
                <option value="ІНЕБ">Інститут економіки та бізнесу</option>
                <option value="ІІМВСПН">Інститут історії, міжнародних відносин та соціально-політичних наук</option>
                <option value="ІКМ">Інститут культури і мистецтв</option>
                <option value="ІПП">Інститут педагогіки і психології</option>
                <option value="ІПУАПО">Інститут публічного управління, адміністрування та післядипломної освіти</option>
                <option value="ІТОТТ">Інститут торгівлі, обслуговуючих технологій і туризму</option>
                <option value="ІФМІТ">Інститут фізики, математики та інформаційних технологій</option>
                <option value="ІФВіС">Інститут фізичного виховання і спорту</option>
                <option value="ФІМ">Факультет іноземних мов</option>
                <option value="ФПН">Факультет природничих наук</option>
                <option value="ФУФСК">Факультет української філології та соціальних комунікацій</option>
              </select>
            </label>
        </div>
        <div class="eduform-filter">
            <span><b>Форма навчання:</b></span>
            <label for="DFN">
            <input type="radio" id="DFN" name="eduform" value="ДФН"/>ДФН
            </label>
            <label for="ZFN">
            <input type="radio" id="ZFN" name="eduform" value="ЗФН"/>ЗФН 
            </label>
            <label for="ALL">
            <input type="radio" id="ALL" name="eduform" value="" checked/>Уcі 
            </label>
        </div>
        <div class="year-filter">
            <span><b>Рік випуску:</b></span>
            <div class="year-filter-checkboxes">
              <label for="2022"><input type="checkbox" id="2022" name="year[]" value="2022" checked>2022</label>
              <label for="2021"><input type="checkbox" id="2021" name="year[]" value="2021" checked>2021</label>
              <label for="2020"><input type="checkbox" id="2020" name="year[]" value="2020" checked>2020</label>
              <label for="2019"><input type="checkbox" id="2019" name="year[]" value="2019" checked>2019</label>
              <label for="2018"><input type="checkbox" id="2018" name="year[]" value="2018" checked>2018</label>
              <label for="2017"><input type="checkbox" id="2017" name="year[]" value="2017" checked>2017</label>
              <label for="2016"><input type="checkbox" id="2016" name="year[]" value="2016" checked>2016</label>
              <label for="2015"><input type="checkbox" id="2015" name="year[]" value="2015" checked>2015</label>
             </div>
             <input class='btn btn-small' type="button" onclick="togglecheckboxes('year[]')" value="×" />
        </div>
        <!--<br>
        <br>
        <h3 style="color: red; font-weight: 600; margin: 0 auto;">Тривають технічні роботи, стабільність сервісу тимчасово не гарантується</h3> -->
        </form>
    </header>

<?php

//include 'connect.php';

//START OF THE APP
/*$host = "localhost:3306";
$user = "e32270_dbuser";
$password = "!6985Vdk21";
$database = "e32270_worksdb";

// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_set_charset($link, "utf8");
 
// выполняем операции с базой данных
$query ="SELECT * FROM Project";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));*/ 

/*if($result)
{
    $rows = mysqli_num_rows($result); // количество полученных строк
     
    echo "<table><tr><th>Підрозділ</th><th>Спеціальність</th><th>Назва роботи</th><th>Керівник</th><th>Форма навчання</th><th>Рік захисту</th><th>Анотація</th><th>Ключові слова</th></tr>";
        for ($i = 0 ; $i < $rows ; ++$i)
                {
                    $row = mysqli_fetch_row($result);
                    $search = mb_strtolower($row[2]);
                    $match = mb_strtolower($_GET["worktitle"]);
                    if (substr_count($search, $match) > 0)
                    {
                        echo "<tr>";
                            for ($j = 0 ; $j < 6 ; ++$j) echo "<td>$row[$j]</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
     
    // очищаем результат
    mysqli_free_result($result);
}*/

// закрываем подключение
mysqli_close($link);
?>
<p class="credits">ДЗ «ЛНУ імені Тараса Шевченка»</p>
</body>
</html>