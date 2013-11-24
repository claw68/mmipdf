<?php

class Reports extends Controller
{
	
	public function Reports()
	{
		parent::Controller();
    	$this->load->model('Mmi_m','query');
   		$this->load->helper('url'); 
    	$this->load->library('session');
		$this->load->library('pdf');
	}
	
	private function _generate_pdf($label,$htmlm,$htmlf)
	{
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		
		$author = "Bukidnon State University Computer Society";
		$title = "Tabulation Report";
		$subject = "Tabulation Report";
		$keywords = "Tabulation Report";
		$filename = "Tabulation";
		
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($author);
		$pdf->SetTitle($title);
		$pdf->SetSubject($subject);
		$pdf->SetKeywords($keywords);
		
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		$pdf->setLanguageArray('eng');
		
		// set font
		$pdf->SetFont('helvetica', '', 10);
		
		// add a page
		$pdf->AddPage('L');
		$pdf->writeHTML($htmlm, true, false, true, false, '');
		$pdf->lastPage();
		
		// add a page
		$pdf->AddPage('L');
		$pdf->writeHTML($htmlf, true, false, true, false, '');
		$pdf->lastPage();
		
		$pdf->Output("pdf/".$filename.'-'.$label.'.pdf', 'FD');
	}
	
	private function _get_pdf_judge_rows($judge_id,$event_id,$cont_gen)
	{
		$responce = new stdClass();
		$data['crit'] = $this->query->getAllCrit($event_id.$cont_gen);
		$countcont = $this->query->getCountCont();
		
		$this->query->setupdateRank($event_id,$cont_gen,$judge_id);
		
		for($i=0;$i<$countcont/2;$i++)
		{
			$grid_data[$i]['cont_id'] = $i+1;
			for($j=0;$j<sizeof($data['crit']);$j++)
			{
				$cont_id = $i+1;
				$grid_data[$i]['crit_num_'.$data['crit'][$j]->crit_id] = $this->query->getScore($event_id,$cont_id.$cont_gen,$judge_id,$data['crit'][$j]->crit_id);
			}
			$cont_id = $i+1;
			$grid_data[$i]['total'] = $this->query->getTotalScore($event_id,$cont_id.$cont_gen,$judge_id);
			$grid_data[$i]['rank'] = $this->query->getRank($cont_id.$cont_gen,$judge_id,$event_id);
		}
		
		$result=$grid_data;
		
		for($i=0;$i<sizeof($result);$i++)
		{
			$responce->rows[$i]['id']=$i;
			$responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
			for($j=0;$j<(sizeof($data['crit']));$j++)
			{
				$responce->rows[$i]['cell'][$j+1] = $result[$i]['crit_num_'.$data['crit'][$j]->crit_id];
			}
			$responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
			$responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
		}
		
		return $responce;
	}
	
	private function _get_pdf_best_rows($event_id,$cont_gen)
	{
		$responce = new stdClass();
		$data['judge'] = $this->query->getAllJudge();
		$countcont = $this->query->getCountCont();
		/////////update ranks
		$this->query->setupdateBestRank($event_id.$cont_gen,$cont_gen);
		
		for($i=0;$i<$countcont/2;$i++)
		{
			$grid_data[$i]['cont_id'] = $i+1;
			for($j=0;$j<sizeof($data['judge']);$j++)
			{
				$cont_id = $i+1;
				$grid_data[$i]['judge_num_'.$data['judge'][$j]->judge_id] = $this->query->getRank($cont_id.$cont_gen,$data['judge'][$j]->judge_id,$event_id.$cont_gen);
			}
			$cont_id = $i+1;
			$grid_data[$i]['total'] = $this->query->getTotalRank($event_id.$cont_gen,$cont_id.$cont_gen);
			$grid_data[$i]['rank'] = $this->query->getBestRank($cont_id.$cont_gen,$event_id.$cont_gen);
		}
		
		$result=$grid_data;
		
		//finalize json format
		for($i=0;$i<sizeof($result);$i++)
		{
			$responce->rows[$i]['id']=$i;
			$responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
			for($j=0;$j<(sizeof($data['judge']));$j++)
			{
				$responce->rows[$i]['cell'][$j+1] = $result[$i]['judge_num_'.$data['judge'][$j]->judge_id];
			}
			$responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
			$responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
		}
		return $responce;
	}
	
	private function _get_pdf_top_rows($cont_gen)
	{
		$responce = new stdClass();
		$data['event'] = $this->query->getAllEvent();
		$countcont = $this->query->getCountCont();
		/////////update ranks
		$this->query->setupdateTopRank($cont_gen);
		
		for($i=0;$i<$countcont/2;$i++)
		{
			$grid_data[$i]['cont_id'] = $i+1;
			for($j=0;$j<sizeof($data['event']);$j++)
			{
				$cont_id = $i+1;
				$grid_data[$i]['event_num_'.$data['event'][$j]->event_id] = $this->query->getBestRank($cont_id.$cont_gen,$data['event'][$j]->event_id.$cont_gen);
			}
			$cont_id = $i+1;
			$grid_data[$i]['total'] = $this->query->getTotalBest($cont_id.$cont_gen);
			$grid_data[$i]['rank'] = $this->query->getTopRank($cont_id.$cont_gen);
		}
		
		$result=$grid_data;
		
		for($i=0;$i<sizeof($result);$i++)
		{
			$responce->rows[$i]['id']=$i;
			$responce->rows[$i]['cell'][0] =  $result[$i]['cont_id'];
			for($j=0;$j<(sizeof($data['event']));$j++)
			{
				$responce->rows[$i]['cell'][$j+1] = $result[$i]['event_num_'.$data['event'][$j]->event_id];
			}
			$responce->rows[$i]['cell'][$j+1] =  $result[$i]['total'];
			$responce->rows[$i]['cell'][$j+2] =  $result[$i]['rank'];
		}
		
		return $responce;
	}
	
	public function generate_judge($judge = 1,$event = 1,$debug = 0)
	{
		
	    $data['eventInfo'] = $this->query->getEventInfo($event);
	    $data['judge'] = $this->query->getJudgeInfo($judge);
		
		$responce = Array('f' => $this->_get_pdf_judge_rows($judge, $event, 'f'), 'm' => $this->_get_pdf_judge_rows($judge, $event, 'm'));
		
		$gender = "m";
		$data['gender'] = $gender;
		$data['crit'] = $this->query->getAllCrit($event.$gender);
		$data['responce'] = $responce[$gender];
	    $htmlm = $this->load->view('reports/judge',$data,TRUE);
		
		$gender = "f";
		$data['gender'] = $gender;
		$data['crit'] = $this->query->getAllCrit($event.$gender);
		$data['responce'] = $responce[$gender];
		$htmlf = $this->load->view('reports/judge',$data,TRUE);
		
		if($debug)
		{
			echo $htmlm.$htmlf;
		} 
		else 
		{
			$this->_generate_pdf($data['eventInfo']->event_name."-".$data['judge']->judge_name, $htmlm, $htmlf);
		}
	}
	
	public function generate_best($event = 1,$debug = 0)
	{
		
	    $data['eventInfo'] = $this->query->getEventInfo($event);
	    $data['judge'] = $this->query->getAllJudge();
		
		$responce = Array('f' => $this->_get_pdf_best_rows($event, 'f'), 'm' => $this->_get_pdf_best_rows($event, 'm'));
		
		$gender = "m";
		$data['gender'] = $gender;
		$data['responce'] = $responce[$gender];
	    $htmlm = $this->load->view('reports/best',$data,TRUE);
		
		$gender = "f";
		$data['gender'] = $gender;
		$data['responce'] = $responce[$gender];
		$htmlf = $this->load->view('reports/best',$data,TRUE);
		
		if($debug)
		{
			echo $htmlm.$htmlf;
		} 
		else 
		{
			$this->_generate_pdf("Best-in-".$data['eventInfo']->event_name, $htmlm, $htmlf);
		}
	}

	public function generate_top($debug = 0)
	{
	    $data['event'] = $this->query->getAllEvent();
		$data['judge'] = $this->query->getAllJudge();
		
		$responce = Array('f' => $this->_get_pdf_top_rows('f'), 'm' => $this->_get_pdf_top_rows('m'));
		
		$gender = "m";
		$data['gender'] = $gender;
		$data['responce'] = $responce[$gender];
	    $htmlm = $this->load->view('reports/top',$data,TRUE);
		
		$gender = "f";
		$data['gender'] = $gender;
		$data['responce'] = $responce[$gender];
		$htmlf = $this->load->view('reports/top',$data,TRUE);
		
		if($debug)
		{
			echo $htmlm.$htmlf;
		} 
		else 
		{
			$this->_generate_pdf("Final-Ranks", $htmlm, $htmlf);
		}
	}
}