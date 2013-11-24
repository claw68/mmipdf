<?php
  class Mmi_m extends Model {

    function Mmi_m(){
      parent::Model();
      $this->load->database();    
    }
    function getAllEvent()
    {
      $this->db->order_by('event_id');
      $query = $this->db->get('event');
      return $query->result();
    }
    function getAllEventNoTalent()
    {
      $this->db->where('event_id !=', '4');
      $this->db->order_by('event_id');
      $query = $this->db->get('event');
      return $query->result();
    }
    function getCountCont()
    {
      $query = $this->db->get('cont');
      return $query->num_rows();
    }
    function getContInfo($cont_id)
    {
      $this->db->where('cont_id',$cont_id);
      $query = $this->db->get('cont');
      $result = $query->result();
      return $result[0];
    }
    function getAllCrit($event_id)
    { $this->db->order_by('crit_id');
      $this->db->where('event_id',$event_id);
      $query = $this->db->get('crit');
      return $query->result();
    }
    function getJudgeName($judge_id)
    {
      $this->db->where('judge_id',$judge_id);
      $query = $this->db->get('judge');
      $result = $query->result();
      return $result[0]->judge_name;
    }
    function getJudgeInfo($judge_id)
    {
      $this->db->where('judge_id',$judge_id);
      $query = $this->db->get('judge');
      $result = $query->result();
      return $result[0];
    }
    function getEventInfo($event_id)
    {
      $this->db->where('event_id',$event_id);
      $query = $this->db->get('event');
      $result = $query->result();
      return $result[0];
    }
	function setEventStatus($event_id,$status)
	{
		$data = Array('status' => $status);
		$this->db->where('event_id', $event_id);
		$this->db->update('event', $data);
		return $event_id;
	}
    function userIdentify($judge_login,$judge_pass)
    {
      $this->db->where('judge_login',$judge_login);
      $this->db->where('judge_pass',$judge_pass);
      $query = $this->db->get('judge'); 
      if ($query->num_rows() > 0){
        $result = $query->result();
        return $result[0]->judge_id;
      }
      else{
        return FALSE;
      }   
    }
        function insertScore($cont_id,$judge_id,$event_id,$crit_id,$score){
      $data = array(
        'cont_id' => $cont_id ,
        'judge_id' => $judge_id ,
        'score' => $score);
        
      $this->db->insert('score', $data); 
      
      $data = array(
        'event_id' => $event_id,
        'crit_id' => $crit_id,
        'score_id' => $this->db->insert_id());
        
      $this->db->insert('event_crit', $data);   
    }
    
    function updateScore($cont_id,$judge_id,$event_id,$crit_id,$score){
      $sql = 'UPDATE event_crit a, score b
              SET b.score = ?
              WHERE b.score_id = a.score_id AND b.cont_id = ? AND b.judge_id = ? AND a.event_id = ? AND a.crit_id = ?';
    
      $this->db->query($sql, array($score,$cont_id,$judge_id,$event_id,$crit_id)); 
    }
    
    function setScore($cont_id,$judge_id,$event_id,$crit_id,$score){
      $sql = 'SELECT a.event_id, a.crit_id, b.cont_id,b.judge_id, b.score
              FROM event_crit a, score b
              WHERE b.score_id = a.score_id AND b.cont_id = ? AND b.judge_id = ? AND a.event_id = ? AND a.crit_id = ?';
      $query = $this->db->query($sql, array($cont_id,$judge_id,$event_id,$crit_id));
       
      if ($query->num_rows() > 0){
        $this->updateScore($cont_id,$judge_id,$event_id,$crit_id,$score);
      }
      else{
        $this->insertScore($cont_id,$judge_id,$event_id,$crit_id,$score);
      }         
    }
      function getAllScore($event_id,$cont_id,$judge_id){
      $sql = 'SELECT b.score
              FROM event_crit a, score b
              WHERE a.score_id = b.score_id AND a.event_id = ? AND b.cont_id = ? AND b.judge_id = ?
              ORDER BY a.crit_id';

      $query = $this->db->query($sql, array($event_id,$cont_id,$judge_id));
      if ($query->num_rows() > 0){
        return $query->result();
      }
      else{
        return FALSE;
      }     
    }
    
    //////aaaaaaaaaaaaaaaddddddddddddddmmmmmmmmmmmmiiiiiiiiiiinnnnnnnnnnnnnn
     //////ppppppppprrrrrrrooooooooooooooojjjjjjjjjjjjjjjjj
         function getAllTotalScore($event_id,$cont_id){
      $sql = 'SELECT judge_id,SUM(c.crit_percent*b.score) AS total
FROM event_crit a, score b, crit c
WHERE a.crit_id = c.crit_id AND a.score_id = b.score_id AND a.event_id = ? AND b.cont_id = ?
group by judge_id
order by RAND()';

      $query = $this->db->query($sql, array($event_id,$cont_id));
      $result = $query->result_array();
      $total = $this->getEmptyJudge($result);
      
      $j=0;
       for($i=sizeof($result);$i<sizeof($this->getAllJudge());$i++)
       {  
          $result[$i]['judge_id'] = $total[$j]->judge_id;
          $result[$i]['total'] = 0;
          $j++;
       }
//for xampp 1.7.4 rounding code
      for($i=0;$i<sizeof($this->getAllJudge());$i++)
       {
       $result[$i]['total'] = round($result[$i]['total'],2);
       }
       return $result; 
       
       
    }
    function getEmptyJudge($total)
     {
     $this->db->where('judge_id !=', '101');
     foreach($total as $judge_id)
     {$this->db->where('judge_id !=', $judge_id['judge_id']);}
     $query = $this->db->get('judge');
     $result = $query->result();
     return $result;
     }
     /////eeeeeeennnnnnndddddddd ppppppprrrrrroooooooooojjjjjjj
    function getAllJudge(){
    $this->db->where('judge_id !=','101');
    $this->db->order_by('judge_name');
    $query = $this->db->get('judge');
    return $query->result();
    }

    function getScore($event_id,$cont_id,$judge_id,$crit_id){
      $sql = 'SELECT b.score
              FROM event_crit a, score b
              WHERE a.score_id = b.score_id AND a.event_id = ? AND b.cont_id = ? AND b.judge_id = ? AND a.crit_id = ?';

      $query = $this->db->query($sql, array($event_id,$cont_id,$judge_id,$crit_id));
      if ($query->num_rows() > 0){
        $result = $query->result();
        return $result[0]->score;
      }
      else{
        return '0';
      }     
    }
        function getTotalScore($event_id,$cont_id,$judge_id){
      $sql = 'SELECT SUM(c.crit_percent*b.score) AS total
              FROM event_crit a, score b, crit c
              WHERE a.crit_id = c.crit_id AND a.score_id = b.score_id AND a.event_id = ? AND b.cont_id = ? AND b.judge_id = ? ';

      $query = $this->db->query($sql, array($event_id,$cont_id,$judge_id));
      $result = $query->result_array();
    
      if ($result[0]['total'] ==""){
        return "0";
      }
      else{
        return round($result[0]['total'],2);
      }     
    }
    
    /////////////////////summary for criteria to event
    
    function getForRankTotal($event_id,$cont_gen,$judge_id)
    {
     $sql = 'SELECT b.cont_id,SUM(c.crit_percent*b.score) AS total
              FROM event_crit a, score b, crit c
              WHERE a.crit_id = c.crit_id AND a.score_id = b.score_id AND a.event_id = ? and b.cont_id LIKE "%'. $cont_gen .'" AND b.judge_id = ? 
Group by b.cont_id
order by total desc ';

      $query = $this->db->query($sql, array($event_id,$judge_id));
       $result = $query->result_array();
        
       // return $result;
       $total = $this->getEmptyTotal($result,$cont_gen);
       $j=0;
       for($i=sizeof($result);$i<($this->getCountCont()/2);$i++)
       {  
          $result[$i]['cont_id'] = $total[$j]->cont_id;
          $result[$i]['total'] = 0;
          $j++;
       }
       //for xampp 1.74 rounding code
       for($i=0;$i<($this->getCountCont()/2);$i++)
       {
       $result[$i]['total'] = round($result[$i]['total'],2);
       }
       
       
       return $result;

             
     }
     
     function getEmptyTotal($total,$cont_gen)
     {
     $this->db->like('cont_id', $cont_gen, 'before');
     foreach($total as $cont_id)
     {$this->db->where('cont_id !=', $cont_id['cont_id']);}
     $query = $this->db->get('cont');
     $result = $query->result();
     return $result;
     }
     
     
    function insertRank($cont_id,$judge_id,$event_id,$rank,$total){
      
      $data = array(
        'cont_id' => $cont_id,
        'judge_id' => $judge_id,
        'event_id' => $event_id,
        'rank' => $rank,
        'total' => $total
      );
        
      $this->db->insert('rank_one', $data);   
    }
    
    function updateRank($cont_id,$judge_id,$event_id,$rank,$total){
      $data = array(
               'rank' => $rank,
               'total' => $total
      );

      $this->db->where('cont_id', $cont_id);
      $this->db->where('judge_id', $judge_id);
      $this->db->where('event_id', $event_id);
      $this->db->update('rank_one', $data);
 
    }
    
    function setRank($cont_id,$judge_id,$event_id,$rank,$total){
      $this->db->where('cont_id',$cont_id);
      $this->db->where('judge_id',$judge_id);
      $this->db->where('event_id',$event_id);
      $query = $this->db->get('rank_one'); 
       
      if ($query->num_rows() > 0){
        $this->updateRank($cont_id,$judge_id,$event_id,$rank,$total);
      }
      else{
        $this->insertRank($cont_id,$judge_id,$event_id,$rank,$total);
      }         
    }
    function getSameTotal($judge_id,$event_id,$total)
    {
      $sql = 'SELECT *
              FROM rank_one
              WHERE judge_id = ? and event_id =? and total = '.$total ;
        $query = $this->db->query($sql, array($judge_id,$event_id));
      if ($query->num_rows() > 0){
      return $query->result();
      }
      else{
       return FALSE;
      } 
     // return $total;
    }
    function getRank($cont_id,$judge_id,$event_id)
    {
      $this->db->where('cont_id',$cont_id);
      $this->db->where('judge_id',$judge_id);
      $this->db->where('event_id',$event_id);
      $query = $this->db->get('rank_one');
      $result = $query->result();
      return $result[0]->rank; 
    }
  function setupdateRank($event_id,$cont_gen,$judge_id){

   $countcont = $this->getCountCont();
   $totals = $this->getForRankTotal($event_id,$cont_gen,$judge_id);
    $rank = Array();
   for($i=0;$i<$countcont/2;$i++){
    $totals[$i]['rank'] = ($i+1);
   }
   
   for($i=0;$i<$countcont/2;$i++){
   $this->setRank($totals[$i]['cont_id'],$judge_id,$event_id,$totals[$i]['rank'],$totals[$i]['total']);
   }
    
   for($i=0;$i<$countcont/2;$i++){
     $check = $totals[$i]['total'];
     $same = Array();
     $same = $this->getSameTotal($judge_id,$event_id,$check);
     
     if($same){
        $totalrank =0;
        for($j=0;$j<sizeof($same);$j++){
          $totalrank += $same[$j]->rank; 
        }
        $totals[$i]['rank'] = ($totalrank/(sizeof($same)));
      }
    }
   
     for($i=0;$i<$countcont/2;$i++){
   $this->setRank($totals[$i]['cont_id'],$judge_id,$event_id,$totals[$i]['rank'],$totals[$i]['total']);
   }     
  }
  
  function setupdateAllRanks()
  {
   $judges = $this->getAllJudge();
   $events = $this->getAllEvent();
   $cont_gens[0] = "m";
   $cont_gens[1] = "f";
   
   for($j1=0;$j1<sizeof($judges);$j1++)
   {
   
   for($e=0;$e<sizeof($events);$e++)
   {
   for($g=0;$g<sizeof($cont_gens);$g++)
   {
   $judge_id = $judges[$j1]->judge_id;
   $event_id = $events[$e]->event_id;
   $cont_gen = $cont_gens[$g];
  
   $countcont = $this->getCountCont();
   $totals = $this->getForRankTotal($event_id.$cont_gen,$cont_gen,$judge_id);
    $rank = Array();
   for($i=0;$i<$countcont/2;$i++)
   {
    $totals[$i]['rank'] = ($i+1);
   }
   
   for($i=0;$i<$countcont/2;$i++)
   {
   $this->setRank($totals[$i]['cont_id'],$judge_id,$event_id.$cont_gen,$totals[$i]['rank'],$totals[$i]['total']);
   }
    
   for($i=0;$i<$countcont/2;$i++)
   {
     $check = $totals[$i]['total'];
     $same = Array();
     $same = $this->getSameTotal($judge_id,$event_id.$cont_gen,$check);
     if($same){    
     $totalrank =0;

     for($j=0;$j<sizeof($same);$j++)
     {
       $totalrank += $same[$j]->rank; 
     }
     $totals[$i]['rank'] = ($totalrank/(sizeof($same)));
     }
   }
   
     for($i=0;$i<$countcont/2;$i++)
   {
   $this->setRank($totals[$i]['cont_id'],$judge_id,$event_id.$cont_gen,$totals[$i]['rank'],$totals[$i]['total']);
   }
       
  
  
  }////end loop for all gender
  }////end loop for all events
  }////end loop for all judges   
}//end function  


///////////////best in something functions  
 function getTotalRank($event_id,$cont_id){
      $sql = 'select sum(rank) as total
              from rank_one
              where cont_id = ? and event_id = ?';

      $query = $this->db->query($sql, array($cont_id,$event_id));
      $result = $query->result_array();
    
      if ($result[0]['total'] ==""){
        return "0";
      }
      else{
        return round($result[0]['total'],2);
      }
      }
      
    function getForBestTotal($event_id,$cont_gen)
    {
     $sql = 'select cont_id, sum(rank) as total
from rank_one
where event_id = ?
group by cont_id
order by total ';

      $query = $this->db->query($sql, array($event_id));
       $result = $query->result_array(); 

       $total = $this->getEmptyTotal($result,$cont_gen);
       $j=0;
       for($i=sizeof($result);$i<($this->getCountCont()/2);$i++)
       {  
          $result[$i]['cont_id'] = $total[$j]->cont_id;
          $result[$i]['total'] = 0;
          $j++;
       }
             //for xampp 1.74 rounding code
       for($i=0;$i<($this->getCountCont()/2);$i++)
       {
       $result[$i]['total'] = round($result[$i]['total'],2);
       }
       return $result;
             
     }
         function insertBestRank($cont_id,$event_id,$rank,$total){
      
      $data = array(
        'cont_id' => $cont_id,
        'event_id' => $event_id,
        'rank' => $rank,
        'total' => $total
      );
        
      $this->db->insert('rank_two', $data);   
    }
    
    function updateBestRank($cont_id,$event_id,$rank,$total){
      $data = array(
               'rank' => $rank,
               'total' => $total
      );

      $this->db->where('cont_id', $cont_id);
      $this->db->where('event_id', $event_id);
      $this->db->update('rank_two', $data);
 
    }
    
    function setBestRank($cont_id,$event_id,$rank,$total){
      $this->db->where('cont_id',$cont_id);
      $this->db->where('event_id',$event_id);
      $query = $this->db->get('rank_two'); 
       
      if ($query->num_rows() > 0){
        $this->updateBestRank($cont_id,$event_id,$rank,$total);
      }
      else{
        $this->insertBestRank($cont_id,$event_id,$rank,$total);
      }         
    }
    function getSameBestTotal($event_id,$total)
    {
      $sql = 'SELECT *
              FROM rank_two
              WHERE event_id =? and total = '.$total ;
        $query = $this->db->query($sql, array($event_id));
      if ($query->num_rows() > 0){
      return $query->result();
      }
      else{
       return FALSE;
      } 
     // return $total;
    }
       function getBestRank($cont_id,$event_id)
    {
      $this->db->where('cont_id',$cont_id);
      $this->db->where('event_id',$event_id);
      $query = $this->db->get('rank_two');
      $result = $query->result();
      return $result[0]->rank; 
    }
    
    function setupdateBestRank($event_id,$cont_gen)
  {

   $countcont = $this->getCountCont();
   $totals = $this->getForBestTotal($event_id,$cont_gen);
    $rank = Array();
   for($i=0;$i<$countcont/2;$i++)
   {
    $totals[$i]['rank'] = ($i+1);
   }
   
   for($i=0;$i<$countcont/2;$i++)
   {
   $this->setBestRank($totals[$i]['cont_id'],$event_id,$totals[$i]['rank'],$totals[$i]['total']);
   }
    
   for($i=0;$i<$countcont/2;$i++)
   {
     $check = $totals[$i]['total'];
     $same = Array();
     $same = $this->getSameBestTotal($event_id,$check);
     if($same){
     $totalrank =0;
     
     for($j=0;$j<sizeof($same);$j++)
     {
       $totalrank += $same[$j]->rank; 
     }
     $totals[$i]['rank'] = ($totalrank/(sizeof($same)));
     }
   }
   
   for($i=0;$i<$countcont/2;$i++){
   $this->setBestRank($totals[$i]['cont_id'],$event_id,$totals[$i]['rank'],$totals[$i]['total']);
   }
    
  }  
  /////////////tttttttttooooooooooopppppppppppp ffffffffffxxxxxxxxxxxxnnnnnnnnnnnnnnnn
   function getTotalBest($cont_id){
      $sql = 'select cont_id, sum(rank) as total
from rank_two
where cont_id = ?';

      $query = $this->db->query($sql, array($cont_id));
      $result = $query->result_array();
    
      if ($result[0]['total'] ==""){
        return "0";
      }
      else{
   return round($result[0]['total'],2);
      }
      }  
      function getForTopTotal($cont_gen)
    {
     $sql = 'select cont_id, sum(rank) as total
from rank_two
where cont_id LIKE "%'.$cont_gen.'"
group by cont_id
order by total ';

      $query = $this->db->query($sql);
       $result = $query->result_array(); 

       $total = $this->getEmptyTotal($result,$cont_gen);
       $j=0;
       for($i=sizeof($result);$i<($this->getCountCont()/2);$i++)
       {  
          $result[$i]['cont_id'] = $total[$j]->cont_id;
          $result[$i]['total'] = 0;
          $j++;
       }
                    //for xampp 1.74 rounding code
       for($i=0;$i<($this->getCountCont()/2);$i++)
       {
       $result[$i]['total'] = round($result[$i]['total'],2);
       }       
       return $result; 
      } 
             
     
  function insertTopRank($cont_id,$rank,$total){
      
      $data = array(
        'cont_id' => $cont_id,
        'rank' => $rank,
        'total' => $total
      );
        
      $this->db->insert('rank_fin', $data);   
    }
    
    function updateTopRank($cont_id,$rank,$total){
      $data = array(
               'rank' => $rank,
               'total' => $total
      );

      $this->db->where('cont_id', $cont_id);
      $this->db->update('rank_fin', $data);
 
    }
    
    function setTopRank($cont_id,$rank,$total){
      $this->db->where('cont_id',$cont_id);
      $query = $this->db->get('rank_fin'); 
       
      if ($query->num_rows() > 0){
        $this->updateTopRank($cont_id,$rank,$total);
      }
      else{
        $this->insertTopRank($cont_id,$rank,$total);
      }         
    }
    function getSameTopTotal($cont_gen,$total)
    {
      $sql = 'SELECT *
              FROM rank_fin
              WHERE cont_id LIKE "%'.$cont_gen.'" and total = '.$total ;
        $query = $this->db->query($sql);
      if ($query->num_rows() > 0){
      return $query->result();
      }
      else{
       return FALSE;
      } 
     // return $total;
    }
       function getTopRank($cont_id)
    {
      $this->db->where('cont_id',$cont_id);
      $query = $this->db->get('rank_fin');
      $result = $query->result();
      return $result[0]->rank; 
    }
    
    function setupdateTopRank($cont_gen)
  {

   $countcont = $this->getCountCont();
   $totals = $this->getForTopTotal($cont_gen);
    $rank = Array();
   for($i=0;$i<$countcont/2;$i++)
   {
    $totals[$i]['rank'] = ($i+1);
   }
   
   for($i=0;$i<$countcont/2;$i++)
   {
   $this->setTopRank($totals[$i]['cont_id'],$totals[$i]['rank'],$totals[$i]['total']);
   }
    
   for($i=0;$i<$countcont/2;$i++)
   {
     $check = $totals[$i]['total'];
     $same = Array();
     $same = $this->getSameTopTotal($cont_gen,$check);
     if($same){     
     $totalrank =0;

     for($j=0;$j<sizeof($same);$j++)
     {
       $totalrank += $same[$j]->rank; 
     }
     $totals[$i]['rank'] = ($totalrank/(sizeof($same)));
     }
   }
   
     for($i=0;$i<$countcont/2;$i++)
   {
   $this->setTopRank($totals[$i]['cont_id'],$totals[$i]['rank'],$totals[$i]['total']);
   }
       
  }
}
    