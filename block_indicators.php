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
        global $USER, $CFG, $COURSE;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        //$this->content->text .= print_r($obj);
        if (empty($this->instance)) {
            return $this->content;
        }
        //Get this users count
        $SQL="SELECT COUNT(*) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id' and userid='$USER->id'";
        $result=count_records_sql($SQL);
        $this->content->text=$USER->username." ";
        $this->content->text .= $result;
        //Get the average for all users
        $SQL="SELECT (count(*)/count(distinct(userid))) FROM {$CFG->prefix}LOG WHERE COURSE='$COURSE->id'";
        //$SQL="select count(*) from {$CFG->prefix}log where userid in (select id from {$CFG->prefix}context where contextlevel='50' and instanceid ='$USER->id')";
        $avg=count_records_sql($SQL);
        $this->content->text .= "<br>avg ".round($avg);
        //Generate the light bulb thingy
        if($result < $avg) { $this->content->text .= "<br><img src={$CFG->pixpath}/r.png>"; }
        elseif ($result > $avg ) {$this->content->text .= "<br><img src={$CFG->pixpath}/g.png>"; }
        else { $this->content->text .= "<br><img src={$CFG->pixpath}/o.png>";}
        $this->content->text.="<br>".time();
        
        $strm=substr($COURSE->shortname, 10, 4);
        $coursecode=substr($COURSE->shortname, 0, 9);
        $this->content->text.="<br>$strm,$coursecode";
        $SQL="select id,shortname from {$CFG->prefix}course where shortname like '$coursecode%' and shortname != '$COURSE->shortname'";
        $array=array();
        if($result=get_records_sql($SQL, 0, 5)) {
          foreach ($result as $r){
            $array[$result[$r->id]->id]=$result[$r->id]->shortname;
            $this->content->text .= "<br>".$result[$r->id]->shortname;
          }
        } else {
          $results= array();
        }

        //if ($users = get_records_sql($SQL, 0, 50)) {   // We'll just take the most recent 50 maximum
        //    foreach ($users as $user) {
        //        $users[$user->id]->fullname = fullname($user);
        //    }
        //} else {
        //    $users = array();
        //}
        
        
    }
}

?>
