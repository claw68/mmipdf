<?php

class Mmi_c extends Controller
{
	
	public function Mmi_c()
	{
		parent::Controller();
    $this->load->model('Mmi_m','query');
    $this->load->helper('url'); 
    $this->load->library('session');
	}
			
	function index()
	{
	  if($this->session->userdata('valid')){
      if($this->session->userdata('judge_id')=='101'){
        $data['allJudge'] = $this->query->getAllJudge();
        $data['event'] = $this->query->getAllEvent();
        $this->load->view('mmi_admin',$data);
      }
      else{ 
        $data['judge_name'] = $this->query->getJudgeName($this->session->userdata('judge_id'));
        $data['event'] = $this->query->getAllEventNoTalent();
        //$data['event'] = $this->query->getAllEvent();
	      $data['countCont'] = $this->query->getCountCont();
		    $this->load->view('mmi_view',$data);
		  }
		}
		else{
     $this->load->view('mmi_login');
    } 
	}
	
	function ajax_set_event_status()
	{
		$event_id = $this->input->post('event_id');
		$status = $this->input->post('status');
		if($status == 'Enabled'){
			$status = '0';
		} else {
			$status = '1';
		}
		$stat = $this->query->setEventStatus($event_id,$status);
		$event = $this->query->getEventInfo($event_id);
		$index = $event->status;
		
		if($index == '1'){
			$return = 'Enabled';
		} else {
			$return = 'Disabled';
		}

		echo $return;
	}
	
	function score_form_m()
	{ 
	  $event_id = $this->input->post('event_id')."m";
	  $cont_id = $this->input->post('cont_id')."m";
	  $judge_id = $this->session->userdata('judge_id');
    $data['allScore_m'] = $this->query->getAllScore($event_id,$cont_id,$judge_id);  
	  $data['judge_id'] = $judge_id;
	  $data['contInfo'] = $this->query->getContInfo($cont_id);
    $data['crit'] = $this->query->getAllCrit($event_id);
    $data['event_id'] = $event_id;
    $data['eventInfo'] = $this->query->getEventInfo($event_id);
    $this->load->view('score_form_m',$data);
  }
  
  function score_form_f()
	{ 
	  $event_id = $this->input->post('event_id')."f";
	  $cont_id = $this->input->post('cont_id')."f";
	  $judge_id = $this->session->userdata('judge_id');
    $data['allScore_f'] = $this->query->getAllScore($event_id,$cont_id,$judge_id); 
	  $data['judge_id'] = $judge_id;
	  $data['contInfo'] = $this->query->getContInfo($cont_id);
    $data['crit'] = $this->query->getAllCrit($event_id);
    $data['event_id'] = $event_id;
    $data['eventInfo'] = $this->query->getEventInfo($event_id);
    $this->load->view('score_form_f',$data);
  }
  
  function ajax_set_score_m()
  {
  if($this->input->post('valid')){
    $cont_id = $this->input->post('cont_id_m');
    $judge_id = $this->session->userdata('judge_id');
    $event_id = $this->input->post('event_id_m');
    $crit_id = $this->input->post('crit_id_m');
    $score = $this->input->post('score_m');
 
    for($i=0;$i<sizeof($crit_id);$i++){
      $this->query->setScore($cont_id,$judge_id,$event_id,$crit_id[$i],$score[$i]);
    }
  }   
  else{ 
    echo "<script type=\"text/javascript\">window.location = '../';</script>";
  }
  }
  function ajax_set_score_f()
  {
  if($this->input->post('valid')){
    $cont_id = $this->input->post('cont_id_f');
    $judge_id = $this->session->userdata('judge_id');
    $event_id = $this->input->post('event_id_f');
    $crit_id = $this->input->post('crit_id_f');
    $score = $this->input->post('score_f'); 
  
    for($i=0;$i<sizeof($crit_id);$i++){
      $this->query->setScore($cont_id,$judge_id,$event_id,$crit_id[$i],$score[$i]);
    }  
  }
  else{ 
    echo "<script type=\"text/javascript\">window.location = '../';</script>";
  }
  }
  function ajax_user_login(){

    $account_valid = $this->query->userIdentify($this->input->post('uid'),$this->input->post('password'));
      if($account_valid){
        $this->session->set_userdata('judge_id', $account_valid);
        $this->session->set_userdata('valid', TRUE);
        if($account_valid == '101'){
          echo "admin";
        }
        else
        {
        echo "OK";
        }
      }
      else{
          echo '<div id="notification_error">The login info is not correct.</div>';
      }
     
  }
  function show_grid_m()
  {
    $event_id = $this->input->post('event_id')."m";
    $data['crit'] = $this->query->getAllCrit($event_id);  
    $this->load->view('grid_data_m',$data);
  }
  
  function admin_grid_data_m()
  {
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
      
    $event_id =  $_REQUEST['passvalue1']."m";
    $judge_id =  $_REQUEST['passvalue2'];
    $data['crit'] = $this->query->getAllCrit($event_id);
    $countcont = $this->query->getCountCont();
    /////update ranks
    $cont_gen = "m";
    $this->query->setupdateRank($event_id,$cont_gen,$judge_id);
    
    
    for($i=0;$i<$countcont/2;$i++){
      $grid_data[$i]['cont_id'] = $i+1;
      for($j=0;$j<sizeof($data['crit']);$j++){
        $cont_id = $i+1;
        $grid_data[$i]['crit_num_'.$data['crit'][$j]->crit_id] = $this->query->getScore($event_id,$cont_id."m",$judge_id,$data['crit'][$j]->crit_id);
      }
      $cont_id = $i+1;
      $grid_data[$i]['total'] = $this->query->getTotalScore($event_id,$cont_id."m",$judge_id);
      $grid_data[$i]['rank'] = $this->query->getRank($cont_id."m",$judge_id,$event_id);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
      for($j=0;$j<(sizeof($data['crit']));$j++){
        $responce->rows[$i]['cell'][$j+1] = $result[$i]['crit_num_'.$data['crit'][$j]->crit_id];
      }
      $responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
      $responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
    }                  
    
    echo json_encode($responce);
  }
  function show_grid_f()
  {
    $event_id = $this->input->post('event_id')."f";
    $data['crit'] = $this->query->getAllCrit($event_id);  
    $this->load->view('grid_data_f',$data);
  }
  
  function admin_grid_data_f()
  {
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
      
    $event_id =  $_REQUEST['passvalue1']."f";
    $judge_id =  $_REQUEST['passvalue2'];
    $data['crit'] = $this->query->getAllCrit($event_id);
    $countcont = $this->query->getCountCont();
    /////////update ranks
  
    $cont_gen = "f";
    $this->query->setupdateRank($event_id,$cont_gen,$judge_id);
    
    for($i=0;$i<$countcont/2;$i++){
      $grid_data[$i]['cont_id'] = $i+1;
      for($j=0;$j<sizeof($data['crit']);$j++){
        $cont_id = $i+1;
        $grid_data[$i]['crit_num_'.$data['crit'][$j]->crit_id] = $this->query->getScore($event_id,$cont_id."f",$judge_id,$data['crit'][$j]->crit_id);
      }
      $cont_id = $i+1;
      $grid_data[$i]['total'] = $this->query->getTotalScore($event_id,$cont_id."f",$judge_id);
      $grid_data[$i]['rank'] = $this->query->getRank($cont_id."f",$judge_id,$event_id);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
      for($j=0;$j<(sizeof($data['crit']));$j++){
        $responce->rows[$i]['cell'][$j+1] = $result[$i]['crit_num_'.$data['crit'][$j]->crit_id];
      }
      $responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
      $responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
    }                  
    
    echo json_encode($responce);
  }
  function bottom_grid()
  {
  $data['countcont'] = $this->query->getCountCont();
  $this->load->view('bottom',$data);
  }
  function bottom_grid_data()
  {
    
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
      
    $event_id =   $_REQUEST['passvalue1'];
    $judge_id =  $this->session->userdata('judge_id');
    $data['crit'] = $this->query->getAllCrit($event_id);
    $countcont = $this->query->getCountCont();
    $grid_data[0]['gender'] = "Male";
    for($i=0;$i<$countcont/2;$i++){
      $cont_id = $i+1;
      $grid_data[0]['c_'.($i+1)] = $this->query->getTotalScore($event_id."m",$cont_id."m",$judge_id);
    }
    $grid_data[1]['gender'] = "Female";
    for($i=0;$i<$countcont/2;$i++){
      $cont_id = $i+1;
      $grid_data[1]['c_'.($i+1)] = $this->query->getTotalScore($event_id."f",$cont_id."f",$judge_id);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] = $result[$i]['gender'];
      for($ii=0;$ii<$countcont/2;$ii++){
        $responce->rows[$i]['cell'][$ii+1] = $result[$i]['c_'.($ii+1)];
      }
    }                  
    echo json_encode($responce);
    }
  function proj()
  {
        $data['event'] = $this->query->getAllEvent();
	      $data['countCont'] = $this->query->getCountCont();
		    $this->load->view('mmi_proj',$data);
  }
  function proj_m()
  {
    $event_id = $this->input->post('event_id')."m";
	  $cont_id = $this->input->post('cont_id')."m";
	  $data['judge'] =  $this->query->getAllJudge();
$data['total'] = $this->query->getAllTotalScore($event_id,$cont_id);  
	  $data['contInfo'] = $this->query->getContInfo($cont_id);
    $this->load->view('proj_m',$data);
  }
    function proj_f()
  {
    $event_id = $this->input->post('event_id')."f";
	  $cont_id = $this->input->post('cont_id')."f";
	  $data['judge'] =  $this->query->getAllJudge();
$data['total'] = $this->query->getAllTotalScore($event_id,$cont_id); 
	  $data['contInfo'] = $this->query->getContInfo($cont_id);
    $this->load->view('proj_f',$data);
  }
   function test()
   {
   //$this->query->setupdateAllRanks();
   $cont_gen = "f";
   $event_id = "1".$cont_gen;
   $judge_id = "1";
   $wa = $this->query->getForRankTotal($event_id,$cont_gen,$judge_id);
   //$aw = $this->query->getEmptyTotal($wa,$cont_gen);
   echo "<pre>";
   print_r($wa);
   //print_r($aw);
   echo "</pre>";
   }
   function update()
   {
   $this->query->setupdateAllRanks();
   echo "Done";
   }
   function print_output()
   {
    $judge_id = $this->input->post('judge_id');
    $event_id = $this->input->post('event_id');
    $data['judgeInfo'] = $this->query->getJudgeInfo($judge_id);
    $data['eventInfo'] = $this->query->getEventInfo($event_id);
    $event_id = $this->input->post('event_id')."m";
    $data['crit_m'] = $this->query->getAllCrit($event_id);
    $event_id = $this->input->post('event_id')."f";
    $data['crit_f'] = $this->query->getAllCrit($event_id);
    $this->load->view('print_v',$data);
   }
    function print_output_best()
   {
    $event_id = $this->input->post('event_id');
    $data['eventInfo'] = $this->query->getEventInfo($event_id);
    $data['judge'] = $this->query->getAllJudge();
    $this->load->view('print_v_best',$data);
   }
    function print_output_top()
   {
    $data['event'] = $this->query->getAllEvent();
    $data['judge'] = $this->query->getAllJudge();
    $this->load->view('print_v_top',$data);
   }
  function logout()
  {
   $this->session->set_userdata('valid', FALSE);
   echo "<script type=\"text/javascript\">window.location = '../';</script>";
  }
  function show_best_grid_f()
  {
    $event_id = $this->input->post('event_id')."f";
    $data['judge'] = $this->query->getAllJudge();  
    $this->load->view('best_grid_f',$data);
  }
    function best_grid_data_f()
  {
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    
    $cont_gen = "f";  
    $event_id =  $_REQUEST['passvalue1'];
    $judge_id =  $_REQUEST['passvalue2'];
    
    
    $data['judge'] = $this->query->getAllJudge(); 
    $countcont = $this->query->getCountCont();
	
	//update ranks for all judge
	foreach ($data['judge'] as $judge_id_loop)
    $this->query->setupdateRank($event_id.$cont_gen,$cont_gen,$judge_id_loop->judge_id);
	
    /////////update ranks
    $this->query->setupdateBestRank($event_id.$cont_gen,$cont_gen);
    
    for($i=0;$i<$countcont/2;$i++){
      $grid_data[$i]['cont_id'] = $i+1;
      for($j=0;$j<sizeof($data['judge']);$j++){
        $cont_id = $i+1;
        $grid_data[$i]['judge_num_'.$data['judge'][$j]->judge_id] = $this->query->getRank($cont_id.$cont_gen,$data['judge'][$j]->judge_id,$event_id.$cont_gen);
      }
      $cont_id = $i+1;
      
      $grid_data[$i]['total'] = $this->query->getTotalRank($event_id.$cont_gen,$cont_id.$cont_gen);
      $grid_data[$i]['rank'] = $this->query->getBestRank($cont_id.$cont_gen,$event_id.$cont_gen);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
      for($j=0;$j<(sizeof($data['judge']));$j++){
        $responce->rows[$i]['cell'][$j+1] = $result[$i]['judge_num_'.$data['judge'][$j]->judge_id];
      }
      $responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
      $responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
    }                  
    
    echo json_encode($responce);
  }
   function show_best_grid_m()
  {
    $event_id = $this->input->post('event_id')."m";
    $data['judge'] = $this->query->getAllJudge();  
    $this->load->view('best_grid_m',$data);
  }
    function best_grid_data_m()
  {
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    
    $cont_gen = "m";  
    $event_id =  $_REQUEST['passvalue1'];
    $judge_id =  $_REQUEST['passvalue2'];
    
    
    $data['judge'] = $this->query->getAllJudge(); 
    $countcont = $this->query->getCountCont();

	//update ranks for all judge
	foreach ($data['judge'] as $judge_id_loop)
    $this->query->setupdateRank($event_id.$cont_gen,$cont_gen,$judge_id_loop->judge_id);
	
    /////////update ranks
    $this->query->setupdateBestRank($event_id.$cont_gen,$cont_gen);
    
    for($i=0;$i<$countcont/2;$i++){
      $grid_data[$i]['cont_id'] = $i+1;
      for($j=0;$j<sizeof($data['judge']);$j++){
        $cont_id = $i+1;
        $grid_data[$i]['judge_num_'.$data['judge'][$j]->judge_id] = $this->query->getRank($cont_id.$cont_gen,$data['judge'][$j]->judge_id,$event_id.$cont_gen);
      }
      $cont_id = $i+1;
      
      $grid_data[$i]['total'] = $this->query->getTotalRank($event_id.$cont_gen,$cont_id.$cont_gen);
      $grid_data[$i]['rank'] = $this->query->getBestRank($cont_id.$cont_gen,$event_id.$cont_gen);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
      for($j=0;$j<(sizeof($data['judge']));$j++){
        $responce->rows[$i]['cell'][$j+1] = $result[$i]['judge_num_'.$data['judge'][$j]->judge_id];
      }
      $responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
      $responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
    }                  
    
    echo json_encode($responce);
  }
    function show_top_grid_m()
  {
    $data['event'] = $this->query->getAllEvent();  
    $this->load->view('top_grid_m',$data);
  }
    function top_grid_data_m()
  {
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    
    $cont_gen = "m";  
    $event_id =  $_REQUEST['passvalue1'];
    $judge_id =  $_REQUEST['passvalue2'];
    
    
    $data['event'] = $this->query->getAllEvent(); 
    $countcont = $this->query->getCountCont();
	
    /////////update ranks
    $this->query->setupdateTopRank($cont_gen);
    
    for($i=0;$i<$countcont/2;$i++){
      $grid_data[$i]['cont_id'] = $i+1;
      for($j=0;$j<sizeof($data['event']);$j++){
        $cont_id = $i+1;
        $grid_data[$i]['event_num_'.$data['event'][$j]->event_id] = $this->query->getBestRank($cont_id.$cont_gen,$data['event'][$j]->event_id.$cont_gen);
      }
      $cont_id = $i+1;
      
      $grid_data[$i]['total'] = $this->query->getTotalBest($cont_id.$cont_gen);
      $grid_data[$i]['rank'] = $this->query->getTopRank($cont_id.$cont_gen);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
      for($j=0;$j<(sizeof($data['event']));$j++){
        $responce->rows[$i]['cell'][$j+1] = $result[$i]['event_num_'.$data['event'][$j]->event_id];
      }
      $responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
      $responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
    }                  
    
    echo json_encode($responce);
  }
  function show_top_grid_f()
  {
    $data['event'] = $this->query->getAllEvent();  
    $this->load->view('top_grid_f',$data);
  }
    function top_grid_data_f()
  {
    $page = $_REQUEST['page'];
    $limit = $_REQUEST['rows'];
    $sidx = $_REQUEST['sidx'];
    $sord = $_REQUEST['sord'];
    
    if(!$sidx){$sidx =1;}
    $count=1;  
    if( $count >0 ){$total_pages = ceil($count/$limit);}
    else{$total_pages = 0;}
    if ($page > $total_pages){$page=$total_pages;}
    
    $start = $limit*$page - $limit;
	$responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    
    $cont_gen = "f";  
    $event_id =  $_REQUEST['passvalue1'];
    $judge_id =  $_REQUEST['passvalue2'];
    
    
    $data['event'] = $this->query->getAllEvent(); 
    $countcont = $this->query->getCountCont();
    /////////update ranks
  
    
    $this->query->setupdateTopRank($cont_gen);
    
    for($i=0;$i<$countcont/2;$i++){
      $grid_data[$i]['cont_id'] = $i+1;
      for($j=0;$j<sizeof($data['event']);$j++){
        $cont_id = $i+1;
        $grid_data[$i]['event_num_'.$data['event'][$j]->event_id] = $this->query->getBestRank($cont_id.$cont_gen,$data['event'][$j]->event_id.$cont_gen);
      }
      $cont_id = $i+1;
      
      $grid_data[$i]['total'] = $this->query->getTotalBest($cont_id.$cont_gen);
      $grid_data[$i]['rank'] = $this->query->getTopRank($cont_id.$cont_gen);
    }
    $result=$grid_data;
    
    for($i=0;$i<sizeof($result);$i++){
      $responce->rows[$i]['id']=$i;
      $responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
      for($j=0;$j<(sizeof($data['event']));$j++){
        $responce->rows[$i]['cell'][$j+1] = $result[$i]['event_num_'.$data['event'][$j]->event_id];
      }
      $responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
      $responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
    }                  
    
    echo json_encode($responce);
  }
}

?>
