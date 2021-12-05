<?php

function compare ($line1, $line2, &$hl) {

        $match_cnt = 0;

        foreach ($line1->words as $x)
        {
            $match_cnt_thisword = 0;
            foreach ($line2->words as $y)
            {
                if ($x == $y)
                { 
                    array_push($hl, $y);
                    $match_cnt_thisword++;
                }
                else if (((mb_strlen($x) >= 9) || (mb_strlen($y) >= 9)) && ((mb_strlen($x) >= 5) && (mb_strlen($y) >= 5)))
                {
                    for ($cnt1 = 1; $cnt1 <= 4; $cnt1++)
                    {
                        if ((mb_substr($x, 0, -$cnt1) == $y) || (mb_substr($y, 0, -$cnt1) == $x))
                        {
                            $match_cnt_thisword++;
                            array_push($hl, $y);
                            break;
                        }
                        for ($cnt2 = 1; $cnt2 <= 4; $cnt2++)
                        {
                            if ((mb_substr($x, 0, -$cnt1) == mb_substr($y, 0, -$cnt2)) || (mb_substr($y, 0, -$cnt1) == mb_substr($x, 0, -$cnt2)))
                            {
                                $match_cnt_thisword++;
                                array_push($hl, $y);
                                break 2;
                            }
                        }
                    }
                }
                else if ((mb_strlen($x) >= 6) || (mb_strlen($y) >= 6))
                {
                    for ($cnt1 = 1; $cnt1 <= 3; $cnt1++)
                    {
                        if ((mb_substr($x, 0, -$cnt1) == $y) || (mb_substr($y, 0, -$cnt1) == $x))
                        {
                            $match_cnt_thisword++;
                            array_push($hl, $y);
                            break;
                        }
                        for ($cnt2 = 1; $cnt2 <= 3; $cnt2++)
                        {
                            if ((mb_substr($x, 0, -$cnt1) == mb_substr($y, 0, -$cnt2)) || (mb_substr($y, 0, -$cnt1) == mb_substr($x, 0, -$cnt2)))
                            {
                                $match_cnt_thisword++;
                                array_push($hl, $y);
                                break 2;
                            }
                        }
                    }
                }
                else if ((mb_strlen($x) >= 5) || (mb_strlen($y) >= 5))
                {
                    for ($cnt1 = 1; $cnt1 <= 2; $cnt1++)
                    {
                        if ((mb_substr($x, 0, -$cnt1) == $y) || (mb_substr($y, 0, -$cnt1) == $x))
                        {
                            $match_cnt_thisword++;
                            array_push($hl, $y);
                            break;
                        }
                        for ($cnt2 = 1; $cnt2 <= 2; $cnt2++)
                        {
                            if ((mb_substr($x, 0, -$cnt1) == mb_substr($y, 0, -$cnt2)) || (mb_substr($y, 0, -$cnt1) == mb_substr($x, 0, -$cnt2)))
                            {
                                $match_cnt_thisword++;
                                array_push($hl, $y);
                                break 2;
                            }
                        }
                    }
                }
                else if ((mb_strlen($x) >= 4) || (mb_strlen($y) >= 4))
                {
                    if ((mb_substr($x, 0, -1) == $y) || (mb_substr($y, 0, -1) == $x))
                    {
                        $match_cnt_thisword++;
                        array_push($hl, $y);
                        break;
                    }
                    if ((mb_substr($x, 0, -1) == mb_substr($y, 0, -1)) || (mb_substr($y, 0, -1) == mb_substr($x, 0, -1)))
                    {
                        $match_cnt_thisword++;
                        array_push($hl, $y);
                        break 2;
                    }
                }
            }
            if ($match_cnt_thisword > 0) $match_cnt++;
        }
        
        //echo "$title->uniq <br>";

        return $match_cnt;
}

    //mysqli_free_result($result);
?>