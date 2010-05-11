<?php //$Id: block_indicators.php,v0.1 2010/05/11 ColinBeer

class block_indicators extends block_base {
    function init() {
        $this->title = get_string('Indicators','block_indicators');
        $this->version = 2010051010;
    }
    function get_content() {
        global $USER, $CFG, $COURSE, $SESSION;
        if ($this->content !== NULL) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        if (empty($this->instance))
        {
            return $this->content;
        }
        /////Check the user level and separate students and staff
        $context = get_context_instance(CONTEXT_COURSE,$SESSION->cal_course_referer);
        if ($roles = get_user_roles($context, $USER->id))
        {
          foreach ($roles as $role)
          {
            if($role->roleid != 5 ) // This needs rethinking to cope with other roles
            {
              $canview=1;
            } 
          } 
        }
        if($canview == 1)
        {
        ///// THE STAFF SECTION
          $this->content->text .= "<br>Staff";
          $this->content->text .= "<br><br>Under Construction";
          //get the total number of staff in this term
          
          //get the average hits for the staff in this term
          
          //get the hits for this user in this term
          
          //get the average forum posts and replies for staff this term
          
          //get the number of posts and replies for this user
          
        } else
        {
        ///// THE STUDENT SECTION /////
          
          $this->content->text .= "Effort Tracker for $USER->username";
          
          ////Get this users hitcount
          $SQL="SELECT COUNT(*) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id' and userid='$USER->id'";
          $studentresult=count_records_sql($SQL);
          
          //Get the average for all student users
          $SQL="SELECT (count(*)/count(distinct(userid))) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id' and userid in (select userid from {$CFG->prefix}role_assignments where contextid in
                (select id from {$CFG->prefix}context where contextlevel='50' and instanceid ='3')
                and roleid in  (select id from {$CFG->prefix}role where name='Student'))"; //***** Needs work tis crappy
          //$SQL="select count(*) from {$CFG->prefix}log where userid in (select id from {$CFG->prefix}context where contextlevel='50' and instanceid ='$USER->id')"; //***** Needs work tis crappy
          $avg=round(count_records_sql($SQL));
          echo $avg;
          $muliplier=(100/(2*$avg));
          $studentresult=round($studentresult*$muliplier);
          //$this->content->text .= "<br>$avg $studentresult";
          $this->content->text .= "<br><img src=\"http://chart.apis.google.com/chart?chs=170x70&chd=t:$studentresult&cht=gom&chf=bg,s,EFEFEF&chxt=x,y&chxl=0:||1:|Low||High\"</img>";        
        }
        
        ////Get this users count
        //$SQL="SELECT COUNT(*) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id' and userid='$USER->id'";
        //$result=count_records_sql($SQL);
        //$this->content->text=$USER->username." ";
        //$this->content->text .= $result;
        //
        ////Get the average for all users
        //$SQL="SELECT (count(*)/count(distinct(userid))) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id'";
        ////$SQL="select count(*) from {$CFG->prefix}log where userid in (select id from {$CFG->prefix}context where contextlevel='50' and instanceid ='$USER->id')";
        ////Need to figure this one out at some stage.
        //$avg=count_records_sql($SQL);
        //$this->content->text .= "<br>avg ".round($avg);
        //
        //if($result < $avg) { $this->content->text .= "<br><img src={$CFG->pixpath}/r.png>"; }
        //elseif ($result > $avg ) {$this->content->text .= "<br><img src={$CFG->pixpath}/g.png>"; }
        //else { $this->content->text .= "<br><img src={$CFG->pixpath}/o.png>";}
        //$this->content->text.="<br>".time();
        //
        //$strm=substr($COURSE->shortname, 10, 4);
        //$coursecode=substr($COURSE->shortname, 0, 9);
        //$this->content->text.="<br>$strm,$coursecode";
        //$SQL="select id,shortname from {$CFG->prefix}course where shortname like '$coursecode%' and shortname != '$COURSE->shortname'";
        //$array=array();
        //if($result=get_records_sql($SQL, 0, 5)) {
        //  foreach ($result as $r){
        //    $array[$result[$r->id]->id]=$result[$r->id]->shortname;
        //    $this->content->text .= "<br>".$result[$r->id]->shortname;
        //  }
        //} else {
        //  $results= array();
        //}
        //
        //$this->content->text .= "<br><img src=\"http://chart.apis.google.com/chart?chs=150x60&chd=t:100&cht=gom\"</img>";
        
    }
}

?>
