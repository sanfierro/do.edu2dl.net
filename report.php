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
        

        // выполняем операции с базой данных
        $query = "SELECT * FROM Project WHERE DefendYear IN (2021) ORDER BY Institution, Specialization, Supervisor, Form, Worktitle ASC;";
        $sql_filters = array();
        
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        
        $alert_list = array();
        $rows = mysqli_num_rows($result);
        $temp = "";
        
        for ($i = 0 ; $i < $rows; ++$i)
        {
            $row = mysqli_fetch_row($result);
            if ($temp !== $row[0])
            {
                if ($temp !== "") echo "</tbody></table>";
                switch ($row[0]) {
                    case "ІПП":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут педагогіки і психології</h2></div>";
                        break;
                    case "ІЕБ":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут економіки і бізнесу</h2></div>";
                        break;
                    case "ІІМВСПН":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут історії, міжнародних відносин та соціально-політичних наук</h2></div>";
                        break;
                    case "ІФМІТ":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут фізики, математики та інформаційних технологій</h2></div>";
                        break;
                    case "ІФВіС":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут фізичного виховання і спорту</h2></div>";
                        break;
                    case "ФУФСК":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Факультет української філології та соціальних комунікацій</h2></div>";
                        break;
                    case "ІКМ":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут культури і мистецтв</h2></div>";
                        break;
                    case "ФПН":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Факультет природничих наук</h2></div>";
                        break;
                    case "ІПУАПО":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут публічного управління, адміністрування та післядипломної освіти</h2></div>";
                        break;
                    case "ІТОТТ":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Інститут торгівлі, обслуговуючих технологій і туризму</h2></div>";
                        break;
                    case "ФІМ":
                        echo "<div style='width: 60em; margin: 0 auto; text-align: center'><h2>Факультет іноземних мов</h2></div>";
                        break;
                }
                
                echo "<br><table class='tablesorter report' id='tablesorter'><thead><tr><th><span class='sort-by'>Спеціальність</span></th><th><span class='sort-by'>Тема роботи</span></th>
                <th><span class='sort-by'>Керівник</span></th><th><span class='sort-by'>Форма</span></th>";
                echo "</thead><tbody>";
            }
            
            if ($row[3] == NULL || $row[6] == NULL || $row[7] == NULL)
            {
                echo "<tr>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                if ($row[3] !== NULL)
                {
                    echo "<td>$row[3]</td>";
                }
                else
                    echo "<td style='color: red'><b>Не вказаний</b></td>";
                
                echo "<td>$row[4]</td>";
                
                if ($row[7] == NULL)
                    echo "<td class='notopborder'><b style='color: red'>Ключові слова не надані</b></td>";
                    
                if ($row[6] == NULL)
                   echo "<td class='notopborder spoiler_wrap'><b style='color: red'>Анотація не надана</b></td>";
               
                echo "<script type='text/javascript' src='/spoiler.js'></script>";
                echo "<script type='text/javascript'>
                $(function() {
    			   $('table.tablesorter').tablesorter({ sortList: []});
    		    });</script>";
    		    echo "</tr>";
            }
            
            $temp = $row[0];
        }
        echo "</tbody></table><br><br>";
    ?>
</body>
</html>