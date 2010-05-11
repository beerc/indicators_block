<?php //$Id: block_online_users.php,v 1.54.2.7 2009/11/20 03:08:59 andyjdavis Exp $

/**
 * This block needs to be reworked.
 * The new roles system does away with the concepts of rigid student and
 * teacher roles.
 */
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
        
        //Check the user level
        $context = get_context_instance(CONTEXT_COURSE,$SESSION->cal_course_referer);
        if ($roles = get_user_roles($context, $USER->id))
        {
          foreach ($roles as $role)
          {
            if($role->roleid != 5 )
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
          
        } else
        {
          ///// THE STUDENT SECTION /////
          $this->content->text .= "Effort Tracker for $USER->username";
          //Get the number of students
          $SQL="SELECT COUNT(*) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id'"; //***** Needs work to ensure only student results are returned
          $result=count_records_sql($SQL);
          //$this->content->text=$USER->username." ";
          //$this->content->text .= $result;
          ////Get this users count
          $SQL="SELECT COUNT(*) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id' and userid='$USER->id'";
          $studentresult=count_records_sql($SQL);
          
          //Get the average for all users
          $SQL="SELECT (count(*)/count(distinct(userid))) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id'"; //***** Needs work tis crappy
          //$SQL="select count(*) from {$CFG->prefix}log where userid in (select id from {$CFG->prefix}context where contextlevel='50' and instanceid ='$USER->id')"; //***** Needs work tis crappy
          $avg=round(count_records_sql($SQL));
          $muliplier=round(100/$avg);
          $studentresult=round($studentresult*$muliplier);
          //$this->content->text .= "<br>$studentresult $avg";
          $this->content->text .= "<br><img src=\"http://chart.apis.google.com/chart?chs=170x60&chd=t:$studentresult&cht=gom\"</img>";        
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
