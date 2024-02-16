<?php

trait MyTime
{
    //*
    //* Returns host name of IP address. Should be moved to somewhere sensible...
    //*

    function Host_IP2Address($host)
    {
        return gethostbyaddr($host);
    }

    
    
    //*
    //* 
    //*
    
    function MyTime_Current_Year($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_year" ]+1900;
    }

    
    //*
    //* 
    //*
    
    function MyTime_Current_Month($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_mon" ]+1;
    }
    
    //*
    //* 
    //*
    
    function MyTime_Current_WeekNo($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }

        $weekno=date("W",$mtime);

        return $weekno;
    }
    
    //*
    //* 
    //*
    
    function MyTime_Date_WeekNo($date)
    {
        return
            $this->MyTime_Current_WeekNo
            (
                $this->MyTime_Date_MTime($date)
            );
    }
    //*
    //* 
    //*
    
    function MyTime_Date_Week_Day($date)
    {
      $datehash=$this->MyTime_Date2Hash($date);
      $julian=
          gregoriantojd
          (
              $datehash[ "Month" ],
              $datehash[ "Day" ],
              $datehash[ "Year" ]
          );
      
      $wday=jddayofweek($julian)+1;
      if ($wday==1)
      {
          $wday=7;
      }
      else
      {
          $wday--;
      } 

      return $wday-1;
    }

    //*
    //* 
    //*
    
    function MyTime_Date_MTime($date)
    {
        $datehash=$this->MyTime_Date2Hash($date);
        $mtime=
            strtotime
            (
                join
                (
                    "-",
                    array
                    (
                        $datehash[ "Year" ],
                        $datehash[ "Month" ],
                        $datehash[ "Day" ],
                    )
                )
            );

        return $mtime;
    }
 
    //*
    //* 
    //*
    
    function MyTime_Date_Week_Dates($date)
    {
        return
            array
            (
                $this->MyTime_Date_Week_Start_Date($date),
                $this->MyTime_Date_Week_End_Date($date),
            );
    }
    //*
    //* 
    //*
    
    function MyTime_Date_Week_Start_Date($date)
    {        
        $wday=
            $this->MyTime_Date_Week_Day($date);

        return
            $this->MyTime_Date_Add_N($date,-$wday);        
    }
    //*
    //* 
    //*
    
    function MyTime_Date_Week_End_Date($date)
    {        
        $wday=
            $this->MyTime_Date_Week_Day($date);

        return
            $this->MyTime_Date_Add_N($date,5-$wday);        
    }
 
    //*
    //* 
    //*
    
    function MyTime_Dates_Add_N($dates,$ndays)
    {
        $rdates=array();
        foreach ($dates as $id => $date)
        {
            $rdates[ $id ]=
                $this->MyTime_Date_Add_N($date,$ndays);
        }

        return $rdates;
    }
    
    //*
    //* 
    //*
    
    function MyTime_Date_Add_N($date,$ndays)
    {
        $datehash=$this->MyTime_Date2Hash($date);
        
        $mtime=
            strtotime
            (
                join
                (
                    "-",
                    array
                    (
                        $datehash[ "Year" ],
                        $datehash[ "Month" ],
                        $datehash[ "Day" ],
                    )
                )
            );

        $mtime+=$ndays*60*60*24;
        

        return $this->MyTime_Current_Date_Sort($mtime);
            
    }

    //*
    //* 
    //*
    
    function MyTime_Current_Date($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_mday" ];
    }


    //*
    //* 
    //*
    
    function MyTime_Date_Name($date)
    {
        $date_hash=$this->MyTime_Date2Hash($date);
        
        return
            sprintf("%02d",$date_hash[ "Day" ]).
            "/".
            sprintf("%02d",$date_hash[ "Month" ]).
            "/".
            sprintf("%02d",$date_hash[ "Year" ]).
            "";
    }
    
    //*
    //* 
    //*
    
    function MyTime_Date_Names($dates)
    {
        $names=array();
        foreach ($dates as $id => $date)
        {
            $names[ $id ]=
                $this->MyTime_Date_Name($date);
        }

        return $names;
    }
    
    //*
    //* 
    //*
    
    function MyTime_Current_Date_Text($mtime="")
    {
        return
            sprintf("%02d",$this->MyTime_Current_Date($mtime)).
            "/".
            sprintf("%02d",$this->MyTime_Current_Month($mtime)).
            "/".
            $this->MyTime_Current_Year($mtime).
            "";
    }
    //*
    //* 
    //*
    
    function MyTime_Current_Date_Sort($mtime="")
    {
        return
            $this->MyTime_Current_Year($mtime).
            sprintf("%02d",$this->MyTime_Current_Month($mtime)).
            sprintf("%02d",$this->MyTime_Current_Date($mtime)).
            "";
    }



    //*
    //* 
    //*
    
    function MyTime_Current_WDay($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_wday" ];
    }

    //*
    //* 
    //*
    
    function MyTime_Current_Hour($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_hour" ];
    }

    
    //*
    //* 
    //*
    function MyTime_Current_Minute($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_min" ];
    }

    //*
    //* 
    //*

    function MyTime_Current_Semester($mtime="")
    {
        $semester=1;
        if ($this->MyTime_Current_Month($mtime)>7)
        {
            $semester=2;
        }

        return $semester;
    }
    


    //*
    //* 
    //*
    
    function MyTime_Current_Second($mtime="")
    {
        if ($mtime=="") { $mtime=time(); }
        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        return $timeinfo[ "tm_sec" ];
    }



    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_Curent_Date_Comps()
    {
        return
            join
            (
                ".",
                array
                (
                    $this->MyTime_Current_Year(),
                    sprintf("%02d",$this->MyTime_Current_Month()),
                    sprintf("%02d",$this->MyTime_Current_Date())
                )
            );
    }
    
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_WeekDay($weekday)
    {
        $msgs=$this->MyTime_WeekDays("WeekDays");

        $msg="WARNING! WeekDay '$weekday' not found #1!";
        if ($weekday==0) { $weekday=7; }
        if (isset($msgs[ $weekday-1 ]))
        {
            $msg=$msgs[ $weekday-1 ];
        }
        
        return $msg;
    }

    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_WeekDays()
    {
        return $this->MyLanguage_GetMessages("WeekDays");
    }
    //*
    //* Returns languaged $month name.
    //*

    function MyTime_Month($month,$key="Name")
    {
        if (is_bool($key))
        {
            if ($key) { $key="Title"; }
            else      { $key="Name"; }
        }
        
        $msgs=$this->MyTime_Months($key);

        $msg="WARNING! Month $month not found!";
        if (isset($msgs[ $month-1 ]))
        {
            $msg=$msgs[ $month-1 ];
        }
        
        return $msg;
    }
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_Months($key="Name")
    {
        return $this->MyLanguage_GetMessages("Months",$key);
    }

    //*
    //* Returns $mtime date: DD/MM/YYYY.
    //*

    function MyTime_Date($mtime="",$glue="/")
    {
        $timeinfo=$this->MyTime_Info($mtime);
        return
            join
            (
                $glue,
                array
                (
                    $timeinfo[ "MDay" ],$timeinfo[ "Month" ],$timeinfo[ "Year" ]
                )
            );
            
    }
    
    //*
    //* Returns $mtime time: HH:MM
    //*

    function MyTime_Time($mtime="",$glue=":")
    {
        $timeinfo=$this->MyTime_Info($mtime);
        return
            join
            (
                $glue,
                array
                (
                    $timeinfo[ "Hour" ],$timeinfo[ "Min" ]
                )
            );
            
    }
    
     //*
    //* Tranlate $timeinfo (hash) 'back' to mtime value.
    //*

    function MyTime_Info_2_MTime($timeinfo,$weekday=True)
    {
        if (!is_array($timeinfo))
        {
            $timeinfo=MyTime_Info($timeinfo,$weekday);
        }
        
        return
            mktime
            (
                sprintf("%02d",$timeinfo[ "Hour" ]),
                sprintf("%02d",$timeinfo[ "Min" ]),
                sprintf("%02d",$timeinfo[ "Sec" ]),
                
                sprintf("%02d",$timeinfo[ "Month" ]),
                sprintf("%02d",$timeinfo[ "MDay" ]),
                sprintf("%02d",$timeinfo[ "Year" ])
            );
    }
    
    //*
    //* Reads file info.
    //*

    function MyTime_Info($mtime="",$weekday=True)
    {
        if ($mtime=="") { $mtime=time(); }
        if ($mtime==0) { return ""; }

        $mtime=intval($mtime);
        $rtimeinfo=localtime($mtime,TRUE);

        $timeinfo[ "Year" ]=$rtimeinfo[ "tm_year" ]+1900;
        $timeinfo[ "Month" ]=sprintf("%02d",$rtimeinfo[ "tm_mon" ]+1);
        $timeinfo[ "MDay" ]=sprintf("%02d",$rtimeinfo[ "tm_mday" ]);

        $timeinfo[ "WDay" ]=$rtimeinfo[ "tm_wday" ];

        if ($weekday)
        {
            $timeinfo[ "WeekDay" ]=
                $this->ApplicationObj()->MyTime_WeekDay($rtimeinfo[ "tm_wday" ]);
        }
        
        $timeinfo[ "Hour" ]=sprintf("%02d",$rtimeinfo[ "tm_hour" ]);
        $timeinfo[ "Min" ]=sprintf("%02d",$rtimeinfo[ "tm_min" ]);
        $timeinfo[ "Sec" ]=sprintf("%02d",$rtimeinfo[ "tm_sec" ]);
        $timeinfo[ "t" ]=$mtime;

        return $timeinfo;
    }

     //*
    //* Format $mtime.
    //*

    function TimeStamp2Hour($mtime="",$glue=".")
    {
        $timeinfo=$this->MyTime_Info($mtime,False);

        if (empty($timeinfo)) { return "--"; }

        return
            join
            (
               $glue,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]//,
                  //$timeinfo[ "Sec" ]
               )
            );
    }

    
    //*
    //* Format $mtime.
    //*

    function TimeStamps($mtimes,$sep1="-",$sep2=".")
    {
        $times=array();
        foreach ($mtimes as $mtime)
        {
            array_push
            (
                $times,
                $this->TimeStamp($mtime,$sep1,$sep2)
            );
        }

        return $times;
    }
    
    //*
    //* Format $mtime.
    //*

    function TimeStamp($mtime="",$sep1="-",$sep2=".")
    {
        $timeinfo=$this->MyTime_Info($mtime,False);

        return
            join
            (
               $sep2,
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep1.
            join
            (
               $sep2,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
                  $timeinfo[ "Sec" ]
               )
            );
        
    }
    //*
    //* Format $mtime.
    //*

    function MyTime_HHMM($mtime="",$sep="")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $sep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
               )
            );
    }
    
    //*
    //* Format $mtime.
    //*

    function MyTime_MTime($hash)
    {
        return
            mktime
            (
                $hour   = $hash[ "Hour" ],
                $minute = $hash[ "Minute" ],
                $second = 0,
                $month  = $hash[ "Month" ],
                $day    = $hash[ "Day" ],
                $year   = $hash[ "Year" ]
            );
    }
    //*
    //* Format $mtime.
    //*

    function MyTime_HHMMSS($mtime="",$sep=":")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $sep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
                  $timeinfo[ "Sec" ]
               )
            );
    }
    
    //*
    //* Last dates of months in year.
    //*

    function MyTime_Months_LastDates($year)
    {
        $months_last=
            array
            (
                1  => 31,
                2  => 28,
                3  => 31,
                4  => 30,
                5  => 31,
                6  => 30,
                7  => 31,
                8  => 31,
                9  => 30,
                10 => 31,
                11 => 30,
                12 => 31,
            );

        $leap = date('L', mktime(0, 0, 0, 1, 1, $year));
        if ($leap) { $months_last[2]=29; }

        return $months_last;
    }
    
    
    //*
    //* Last day of $year/$month.
    //*

    function MyTime_Month_LastDate($year,$month)
    {
        $months_last=
            $this->MyTime_Months_LastDates($year);

        return $months_last[ $month ];
    }
        
    //*
    //* Format $mtime.
    //*

    function TimeStamp2Text($mtime="",$sep=", ",$weekday=True)
    {
        $timeinfo=$this->MyTime_Info($mtime,$weekday);

        if (empty($timeinfo)) { return "--"; }

        $text="";
        if ($weekday)
        {
            $text.=$timeinfo[ "WeekDay" ].$sep;
        }

        return
            $text.
            join
            (
               "/",
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep.
            join
            (
               ":",
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
                  $timeinfo[ "Sec" ]
               )
            );
    }

    //*
    //* function MyTime_FileName, Parameter list: $mtime="",$sep=" "
    //*
    //* Format $mtime for a file name..
    //*

    function MyTime_FileName($mtime="",$sep="-",$datesep=".",$timesep=".")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $datesep,
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep.
            join
            (
               $timesep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]//,
                  //$timeinfo[ "Sec" ]
               )
            );
    }

    //* function MyTime_2Sort, Parameter list: $mtime="
    //*
    //* Returns date of $mtime's date key: YYYYMMDD.
    //* Current $mtime, if empty.
    //*

    function MyTime_2Sort($mtime="")
    {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return 
          ($timeinfo[ "tm_year" ]+1900).
          sprintf("%02d",$timeinfo[ "tm_mon" ]+1).          
          sprintf("%02d",$timeinfo[ "tm_mday" ]);
    }
    
    //* function MyTime_Sort2Date, Parameter list: $date=0
    //*
    //* Returns formatted date of $mtime, today if empty.
    //*

    function MyTime_Date2Hash($date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }

        return
            array
            (
                "Year"  => substr($date,0,4),
                "Month" => substr($date,4,2),
                "Day"   => substr($date,6,2),
            );
    }

    //* function MyTime_Sort2Date, Parameter list: $date=0
    //*
    //* Returns formatted date of $mtime, today if empty.
    //*

    function MyTime_Sort2Date($date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }

        $date=$this->MyTime_Date2Hash($date);
        
        return 
            $date[ "Day" ]."/".
            $date[ "Month" ]."/".
            $date[ "Year" ];
    }

    
    function MyTime_Date2Sort($date)
    {
        $comps=preg_split('/\//',$date);
        $formats=array("%02d","%02d","%d");

        $text="";
        for ($n=0;$n<count($formats);$n++)
        {
            $val=0;
            if (isset($comps[ $n ]))
            {
                $val=$comps[ $n ];
            }

            $val=sprintf($formats[$n],$val);
            $text=$val.$text;
        }

        return $text;
    }
    
    function MyTime_2Hash($mtime="")
    {
        if (empty($mtime)) { $mtime=time(); }

        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
        $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
        $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);

        $wday=$timeinfo[ "tm_wday" ];
        if ($wday==0) { $wday=6; }
        else          { $wday--; }

        $timeinfo[ "WeekDay" ]=$this->MyTime_WeekDay($wday);

        $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
        $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
        $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

        return $timeinfo;
    }
    
    //*
    //* function MyTime_Month_MTime_First, Parameter list: $month
    //*
    //* Converts a $year/$month to first time.
    //*

    function MyTime_Month_MTime_First($month)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$month,$matches) && count($matches)>=2)
        {
            $year=$matches[1];
            $month=$matches[2];
            $month=sprintf("01/%02d/%d 00:00:00",$month,$year);
        }
        
        $dateobj = DateTime::createFromFormat("d/m/Y H:i:s",$month);
        return $dateobj->format("U");
    }
    
    //*
    //* function MyTime_Month_MTime_Last, Parameter list: $month
    //*
    //* Converts a $year/$month to last time.
    //*

    function MyTime_Month_MTime_Last($month)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$month,$matches) && count($matches)>=2)
        {
            $year=$matches[1];
            $month=$matches[2];
            
            if ($month<12) { $month++; }
            else           { $month=1; $year++; }

            $month=sprintf("%d%02d",$year,$month);
        }

        return $this->MyTime_Month_MTime_First($month)-1;
        
    }
    
    //*
    //* function MyTime_Date_MTime_First, Parameter list: $date
    //*
    //* Converts a $year/$month/$date to first time.
    //*

    function MyTime_Date_MTime_First($date)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)/',$date,$matches) && count($matches)>=3)
        {
            $year=$matches[1];
            $month=$matches[2];
            $mday=$matches[3];

            $date=sprintf("%02d/%02d/%d 00:00:00",$mday,$month,$year);

            $dateobj = DateTime::createFromFormat("d/m/Y H:i:s",$date);
            return $dateobj->format("U");
        }

        return 0;
    }
    
    //*
    //* function MyTime_Date_End2MTime, Parameter list: $date
    //*
    //* Converts a $year/$month/$date to first time.
    //*

    function MyTime_Date_MTime_Last($date)
    {
        return $this->MyTime_Date_MTime_First($date)+60*60*24-1;
    }
    
    //*
    //* function MyTime_Dates_From_To, Parameter list: $startdate,$enddate
    //*
    //* Returns list of dates between $startdate and $enddate.
    //*

    function MyTime_Dates_From_To($startdate,$enddate)
    {
        if ($startdate>$enddate)
        {
            $tmp=$startdate;
            $startdate=$enddate;
            $enddate=$tmp;
        }
        $dates=array();
        
        $date=$startdate;
        while ($date<=$enddate)
        {
            array_push($dates,$date);
            $date=$this->GetNextDate($date);
        }

        return $dates;
    }
    
    //*
    //* Trims a date string.
    //*

    function MyTime_Date_Trim($value)
    {
        $rval=$value;
        if (preg_match('/\//',$rval) && preg_match('/\d\d?/',$rval,$matches))
        {
            $date=$matches[0];
            $rval=preg_replace('/\d\d?/',"",$rval,1);

            $mon=0;
            if (preg_match('/\d\d?/',$rval,$matches))
            {
                $mon=$matches[0];
                $rval=preg_replace('/\d\d?/',"",$rval,1);
            }

            $year=0;
            if (preg_match('/\d+/',$rval,$matches))
            {
                $year=$matches[0];

                if ($year<=($this->MyTime_Current_Year()-2000)) { $year+=2000; }
                elseif ($year<100) { $year+=1900; }
            }

            $value=sprintf("%04d%02d%02d",$year,$mon,$date);
        }

        return $value;
    }
    
    //*
    //* Trims a date string.
    //*

    function MyTime_Time_Lapse_Text($secs,$start=0)
    {
        $secs-=$start;
        
        $ndays=0;
        $texts=array();
        $n=60*60*24;
        if ($secs>=$n)
        {
            $ndays=floor($secs/$n);
            array_push($texts,$ndays,"days,");

            $secs-=$ndays*$n;
        }
        
        $n=60*60;
        if ($secs>=$n)
        {
            $nhours=floor($secs/$n);
            array_push($texts,$nhours,"hours,");

            $secs-=$ndays*$n;
        }
        
        $n=60;
        if ($secs>=$n)
        {
            $minutes=floor($secs/$n);
            array_push($texts,$minutes,"mins,");

            $secs-=$minutes*$n;
        }
        
        array_push($texts,$secs,"secs");

        return join(" ",$texts);;
    }

}

?>