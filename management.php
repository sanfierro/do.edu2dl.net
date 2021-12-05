<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <title>Теми магістерських робіт</title>
         <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
         <link rel="stylesheet" href="styles.css">
         <link rel="stylesheet" href="scroller.css">
         <script src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
         <script type="text/javascript" src="/tablesorter/js/jquery.tablesorter.js"></script>
         <script type="text/javascript" src="/tablesorter/js/jquery.tablesorter.widgets.js"></script>
    </head>

<body>
    <div class="submitArea">
    <form method="post" action="/management.php">
        <label for="Institutions"><p>Навчальний підрозділ:</p>
              <select name="Institution" id="Institution" required>
                <option value="" disabled selected>Оберіть варіант</option>
                <option value="ІНЕБ">Інститут економіки та бізнесу</option>
                <option value="ІІМВСПН">Інститут історії, міжнародних відносин та соціально-політичних наук</option>
                <option value="ІКМ">Інститут культури і мистецтв</option>
                <option value="ІПП">Інститут педагогіки і психології</option>
                <option value="ІПУАПО">Інститут публічного управління, адміністрування та післядипломної освіти</option>
                <option value="ІТОТТ">Інститут торгівлі, обслуговуючих технологій і туризму</option>
                <option value="ІФМІТ">Інститут фізики, математики та інформаційних технологій</option>
                <option value="ІФВІС">Інститут фізичного виховання і спорту</option>
                <option value="ФІМ">Факультет іноземних мов</option>
                <option value="ФПН">Факультет природничих наук</option>
                <option value="ФУФСК">Факультет української філології та соціальних комунікацій</option>
              </select>
        </label>
        <label for="Specialization"><p>Спеціальність:</p>
            <input type="text" placeholder="Введіть назву спеціальності..." name="Specialization" id="Specialization" required>
        </label>
        <label for="Worktitle"><p>Назва роботи:</p></p></p>
            <input type="text" placeholder="Введіть назву роботи..." name="Worktitle" id="Worktitle" required>
        </label>
        <label for="Supervisor"><p>Керівник:</p>
            <input type="text" placeholder="Введіть прізвище та ініціали керівника..." name="Supervisor" id="Supervisor" required>
        </label>
        <label for="Form">Форма навчання:
            <select name="Form" id="Form" required>
                <option value="" disabled selected>Оберіть варіант</option>
                <option value="ДФН">Денна</option>
                <option value="ЗФН">Заочна</option>
            </select>
        </label>
        <label for="DefendYear">Рік захисту:
            <select name="DefendYear" id="DefendYear" required>
                <option value="2021" selected>2021</option>
                <option value="2020" disabled>2020</option>
            </select>
        </label>
        <label for="Annotation"><p>Анотація:</p>
            <textarea rows="6" cols="73" name="Annotation" id="Annotation" required></textarea>
        </label>
        <label for="Keywords"><p>Ключові слова:</p>
            <textarea rows="6" cols="73" placeholder="Введіть ключові слова (через кому)" name="Keywords" id="Keywords"></textarea>
        </label>
        <br><br>
        <input type="submit" class="btn" name="submit" value="Підтвердити">
        <p style="color: red; font-size: 0.85em"><br>Додавання робот на даний момент недоступно. У разі наявності питань <br> звертайтеся за електронною адресою: 2dl.lnu@gmail.com</p>
    </form>
    </div>
    
   <?php 
  
    function getimg($url) {         
    $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';              
        $headers[] = 'Connection: Keep-Alive';         
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';         
        $user_agent = 'php';         
        $process = curl_init($url);         
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);         
        curl_setopt($process, CURLOPT_HEADER, 0);         
        curl_setopt($process, CURLOPT_USERAGENT, $user_agent); //check here         
        curl_setopt($process, CURLOPT_TIMEOUT, 30);         
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);         
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);         
        $return = curl_exec($process);         
        curl_close($process);         
        return $return;     
    } 

    $imgurl = 'http://do.luguniv.edu.ua/report/log/graph.php?id=1&user=22072&type=userday.png'; 
    $imagename = 'Єнін М.Н.png';
    $image = getimg($imgurl); 
    file_put_contents($imagename,$image);       

    echo "OK! ";
    sleep(10);
    
    ?>
</body>

</html>