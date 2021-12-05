<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <title>Теми магістерських робіт</title>
         <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
         <link rel="stylesheet" href="styles.css">
         <link rel="stylesheet" href="scroller.css">
         <script src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
         <script src="/clipboard/dist/clipboard.min.js"></script>
         <script type="text/javascript" src="/tablesorter/js/jquery.tablesorter.js"></script>
         <script type="text/javascript" src="/tablesorter/js/jquery.tablesorter.widgets.js"></script>
         <script src="/filter.js"></script>
         <script src="//code.jivosite.com/widget/Dylno1zhF7" async></script>
    </head>
<body>

<header>
    <h1>Теми магістерських робіт</h1>
</header>

    <?php
    
        include 'compare.php';
        include 'connect.php';
        
        function multiexplode ($delimiters,$string) {
            $ready = str_replace($delimiters, $delimiters[0], $string);
            $launch = explode($delimiters[0], $ready);
            return  $launch;
        }
    
        function highlightWords($text, $word){
            $abbr = array("ст","рр","р","с","м");
            if (in_array(mb_strtolower($word), $abbr)) $word .= '.';
            $text = preg_replace('#'.preg_quote($word).'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
            return $text;
        }
        
        function isChecked($chkname, $value)
        {
            if(!empty($_GET[$chkname]))
            {
                foreach($_GET[$chkname] as $chkval)
                {
                    if($chkval == $value)
                    {
                        return true;
                    }
                }
            }
            return false;
        }
                
        class Line
        {
            public $name = "";
            public $uniq = 100.0;
            public $words = array();
            public $prepositions = array("","в","з","із","зі","на","про","у","для","по","до","від","та","і","й","що","їх","її","як","щодо","при",
                                        "a","the");
            
            public $synonyms_base = array(
                array("гра", "гри", "ігра", "ігри", "грі", "грою", "ігор", "іграми"),
                array("торговельний", "торгівельний")
            );
            
            function __construct($name)
            {
                $this->name = $name;
                $this->split();
            }
            
            function split()
            {
                $tok = multiexplode(array(" ", ".", ",", "-", "–", "—", ":", ";", "?", "!", "/", "\\", "(", ")", "\"", "«", "»", "„", "”", "“", "]", "[", "\n","\t"), $this->name);
                
                foreach ($tok as $value) {
                    if (!in_array($value, $this->prepositions)) {
                        $this->words[] = mb_strtolower($value);   
                    }
                }
            }
            
            function delete_same()
            {
                $h = array();
                
                for ($i = 0; $i < count($this->words); ++$i)
                {
                    for ($j = $i + 1; $j < count($this->words); ++$j)
                    {
                        $x = new Line($this->words[$i]);
                        $y = new Line($this->words[$j]);
                        if (compare($x, $y, $h) > 0)
                        {
                            //echo "! ";
                            array_splice($this->words, $j, 1);
                        }
                    }
                }
            }
            
            function get_synonyms()
            {
                $temp = array();

                foreach ($this->words as $value)
                {
                    for ($i = 0; $i < sizeof($this->synonyms_base); $i++)
                    {
                        if (in_array($value, $this->synonyms_base[$i]))
                        {
                            foreach ($this->synonyms_base[$i] as $s)
                            {
                                if ($value != $s) $temp[] = $s;
                            }
                            break;
                        }
                    }
                }
                
                $synonyms = new Line(implode(' ', $temp));
                
                return $synonyms;
            }
            
            function print()
            {
                echo '<pre>'; print_r($this->words); echo '</pre>';
            }
        }
        
        if(isset($_GET["worktitle"]))
        {
            $logs = "logs.txt";
            file_put_contents($logs, $_GET["worktitle"]."\n", FILE_APPEND | LOCK_EX);
            
            // выполняем операции с базой данных
            $query = "SELECT * FROM Project ";
            $sql_filters = array();
            $supervisors = array();
            $s = "";
            
            if (isset($_GET["supervisor"]) && $_GET["supervisor"] !== "")
            {
                file_put_contents($logs, '+'.$_GET["supervisor"]."\n", FILE_APPEND | LOCK_EX);
                $temp = "SUBSTRING(Supervisor, 1, LOCATE(' ', Supervisor) - 1) IN (";
                $supervisors = multiexplode(array(" ", ",", "?", "\t"), $_GET["supervisor"]);
                for ($i = 0; $i < count($supervisors); ++$i)
                {
                    if ($supervisors[$i] !== "")
                    {
                        $temp .= "'$supervisors[$i]'";
                        if ($i < count($supervisors) - 1) $temp .= ", ";
                    }
                }
                $temp .= ")";
                $sql_filters[] = $temp;
            }
            if (isset($_GET["eduform"]) && $_GET["eduform"] !== "")
            {
                $s = $_GET["eduform"];
                $sql_filters[] = "Form = '$s'";
            }
            if (isset($_GET["institution"]) && $_GET["institution"] !== "")
            {
                file_put_contents($logs, '+'.$_GET["institution"]."\n", FILE_APPEND | LOCK_EX);
                $s = $_GET["institution"];
                $sql_filters[] = "Institution = '$s'";
            }
            $temp = "DefenseYear IN (";
            $years = array();
            for ($i = 2015; $i <= 2022; $i++)
            {
                if (isChecked("year",$i)) $years[] = $i;
            }
            if (count($years) < 8 && count($years) > 0)
            {
                $temp .= implode(', ', $years).")";
                $sql_filters[] = $temp;
            }
            
            if (count($sql_filters))
            {
                $query .= "WHERE ";
                $query .= implode(' AND ', $sql_filters).";";
            }
            
            $result = mysqli_query($link, $query) or die("Помилка " . mysqli_error($link));
            
            $title = new Line($_GET["worktitle"]);
            $title->delete_same();
            $alert_list = array();
            $rows = mysqli_num_rows($result);
            $sens_koef = $_GET["sensitivity"];
            
            if ($_GET["sensitivity"] > count($title->words)) $sens_koef = count($title->words);
            
            $synonyms = $title->get_synonyms();
            
            for ($i = 0 ; $i < $rows; ++$i) {
                $row = mysqli_fetch_row($result);
                $search = new Line($row[3]);
                $searchKeys = new Line($row[8]);
                $highlight = array();
                
                $match_cnt = compare($title, $search, $highlight);
                compare($title, $searchKeys, $highlight);
                if ((count($synonyms->words) > 0) && (compare($synonyms, $search, $highlight) > 0)) $match_cnt++;
                
                //if ($match_cnt > count ($search->words)) $match_cnt = count ($search->words);
                //if (count($search->words) > count($title->words)) $sim = (1 - $match_cnt / count($search->words)) * 100;
                $sim = (1 - $match_cnt / count($title->words)) * 100;
                //$sim = (1 - $match_cnt / count($search->words)) * 100;
                //$sim = ((1 - $match_cnt / count($search->words)) + (1 - $match_cnt / count($title->words))) / 2 * 100;
                if ($title->uniq > $sim) $title->uniq = $sim;
            
                foreach ($highlight as $x)
                {
                    $row[3] = highlightWords($row[3], $x);
                    $row[3] = highlightWords($row[3], mb_convert_case($x, MB_CASE_TITLE));
                    $row[3] = highlightWords($row[3], mb_strtoupper($x));
                    $row[8] = highlightWords($row[8], $x);
                    $row[8] = highlightWords($row[8], mb_convert_case($x, MB_CASE_TITLE));
                    $row[8] = highlightWords($row[8], mb_strtoupper($x));
                }
                
                if ($match_cnt >= $sens_koef) {
                    //array_push($row, $sim);
                    array_push($row, $match_cnt);
                    $alert_list[] = $row;
                }
            }
            
            echo
            "<div class='ntf-area'>
            <form style='display: inline-block' action='http://do.edu2dl.net/'>
                 <input type='submit' class='btn' value='<< До пошуку' />
            </form>
            <button class='btn copylink'>Копіювати посилання</button>
            <script>
                var clipboard = new ClipboardJS('.copylink', {
                  text: function() {
                    return window.location.href;
                  }
                });
            </script>";
            
            echo "<br><br>Пошуковий запит: <b>$title->name</b><br>";
            if ($_GET["supervisor"] !== "") echo "Науковий керівник – ".$_GET["supervisor"]."<br>";
            echo "<br>";
            
            /*echo "Ступінь новизни: "; 
            if ($title->uniq >= 70) echo "<p style='margin: 0 0; color: green; font-weight: 600; display: inline'>високий </p>";
            else if ($title->uniq <= 33) echo "<p style='margin: 0 0; color: red; font-weight: 600; display: inline'>потребує розгляду </p>";
            else echo "<p style='margin: 0 0; color: black; font-weight: 600; display: inline'>задовільний </p>";*/
            
            //echo "("; echo floor($title->uniq); echo "%)<br><br>";
            echo "<br>Результати за пошуком: ".count($alert_list);
            if(count($alert_list) == 0) echo "<span style='text-align: center'><br>Перевірте корректність запиту або спростіть параметри пошуку.</span>";
            echo'<br><br><input type="search" class="light-table-filter" data-table="tablesorter" placeholder="Фільтр за словом...">';
            echo "<br><br></div>";
            $result = mysqli_query($link, $query) or die("Помилка " . mysqli_error($link));
            
             echo "<table class='tablesorter' id='tablesorter'><thead><tr><th><span class='sort-by'>Підрозділ</span></th><th><span class='sort-by'>Спеціальність</span></th><th><span class='sort-by'>Тема роботи</span></th>
             <th><span class='sort-by'>Керівник</span></th><th><span class='sort-by'>Форма</span></th><th><span class='sort-by'>Рік захисту</span></th>";
             echo "<th>Збіг</th></tr>";
             echo "</thead><tbody>";
             
             foreach ($alert_list as $row)
             {
                  echo "<tr>";
                  for ($j = 1 ; $j < 7 ; ++$j)
                   echo "<td>$row[$j]</td>";
                  echo "<td>"; echo round($row[9]); echo "</td>";
                  if ($row[8] !== NULL && $row[8] !== "") echo "<td class='notopborder'><b>Ключові слова: </b><i>$row[8]</i></td>";
                  if ($row[7] !== NULL)
                  {
                  echo "<td class='notopborder spoiler_wrap'><b>Анотація: </b>
                    <input type='button' value='Показати' />
	                <div class='spoiler_content'>$row[7]</div></td>";
                  }
                echo "</tr>";
             }
             echo "</tbody></table>";

             echo "<script type='text/javascript' src='/spoiler.js'></script>";
             echo "<script type='text/javascript'>
             $(function() {
			   $('table.tablesorter').tablesorter({ sortList: [[6,1], [0,1], [5,1]]});
		    });</script>";
        }
        else
        {
            echo "<div class='ntf-area'>Пошуковий запит порожній. Будь ласка, повторіть спробу <br><br>";
            echo 
            "<form action='index.php'>
                <input type='submit' class='btn' value='<< Повернутися до пошуку' />
            </form></div>";
        }
        
    ?>
</body>
</html>