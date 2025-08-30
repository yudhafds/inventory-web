<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Ahp{
	public function __construct(){
		$this->criteria = array();
		$this->alternative_id = array();
		$this->alt_norm = array();
		$this->result = array();
		$this->result_norm = array();
		$this->aggregated_result = array();
		$this->ranking_result = array();
    }
    
	public function SetCriteria(array $c){
		$this->criteria = $c;
	}
	
	public function SetAlternativeID(array $aid){
		$this->alternative_id = $aid;
	}
	
	public function NormalizeAlternative(array $a){
		$max = array();
		$min = array();
		$this->alt_norm = $a;
		$N = count($a);
		for ($i=0;$i<$N;$i++){
			$cols = count($a[$i]);
			$max[$i] = max($a[$i]);
			$min[$i] = min($a[$i]);
			for ($j=0;$j<$cols;$j++){
				$this->alt_norm[$i][$j] = ((($a[$i][$j]- $min[$i]) / ($max[$i] - $min[$i]))*8)+1;
			}
		}		
		return $this->alt_norm;
	}
	
	public function Pairwise(array $a){
		$countCriteria = count($this->criteria);
		for ($c=0;$c<$countCriteria;$c++){
			$N = count($a[$c]);
			//fill in diagnonal and right upper 
			for ($i=0;$i<$N;$i++){
				for ($j=$i;$j<$N;$j++){
					$this->result[$c][$i][$j] = $a[$c][$i]/$a[$c][$j];
				}
			}
			//fill in left bottom 
			for ($i=1;$i<$N;$i++){
				for ($j=0;$j<$i;$j++){
					$this->result[$c][$i][$j] = $a[$c][$i]/$a[$c][$j];
				}
			}								
		}
		return $this->result;
	}
	
	public function NormalizePairwise(array $pw){
		$N = count($pw);
		$SUM = array();
		$countCriteria = count($this->criteria);
		for ($c=0;$c<$countCriteria;$c++){
			$N = count($pw[$c]);
			for ($col=0;$col<$N;$col++){
				$SUM[$c][$col] = 0;
				for ($r=0;$r<$N;$r++){
					$SUM[$c][$col] = $pw[$c][$r][$col]+$SUM[$c][$col];
				}
			}
			
			for ($i=0;$i<$N;$i++){
				for ($j=0;$j<$N;$j++){
					$this->result_norm[$c][$i][$j] = $pw[$c][$i][$j]/$SUM[$c][$j];
				}
			}
		}
		return $this->result_norm;
	}
	
	public function AggregatePairwise(array $a){		
		$N = count($a);
		$countCriteria = count($this->criteria);
		for ($c=0;$c<$countCriteria;$c++){
			$N = count($a[$c]);
			for ($i=0;$i<$N;$i++){
				$sum_pw_val = 0;
				for ($j=0;$j<$N;$j++){
					$pw_val = $a[$c][$i][$j];
					$sum_pw_val = $sum_pw_val + $pw_val;
				}
				$this->aggregated_result[$c][$i] =$sum_pw_val/$N;
			}
		}
		return $this->aggregated_result;
	}
	
	public function RankPosition(array $a,$ordertype){
		//1 - Descending order, Others - Ascending order
		if ($ordertype==1) $rank=count($a); 
		else $rank=1;
		$array = $a;
		$rank_position = array();
		while (sizeof($array) > 0)
		{
			$max = max($array);
			$keys = array_search($max, $array);
			$rank_position[$keys] = $rank;
			unset($array[$keys]);
			if ($max==0.00969) echo "$max<br>";
			$count=1;
			while($keys = array_search($max, $array)){				
				$rank_position[$keys] = $rank;
				unset($array[$keys]);
				if ($max==0.00969)echo "$max<br>";
				$count++;
			}						
			if ($ordertype==1) $rank = $rank - $count;
			else $rank = $rank + $count;
		}
		ksort($rank_position);
		return $rank_position;
	}
	
	
	public function RankAggregate(array $a, $ordertype){		
		$N = count($a);
		$countAlt = count($this->alternative_id);		
		$countCriteria = count($this->criteria);
		for ($i=0;$i<$countAlt;$i++){
			$this->ranking_result[$i] = 0;
			for ($c=0;$c<$countCriteria;$c++){
				$this->ranking_result[$i] = $this->ranking_result[$i] + $a[$c][$i];
			}
			$this->ranking_result[$i] = $this->ranking_result[$i] / $countCriteria;			
		}						
		$pos = $this->RankPosition($this->ranking_result,$ordertype);
		$ahp_result = array_map(null, $this->alternative_id,$this->ranking_result,$pos);		
		return $ahp_result;
	}
	
	
	public function PrintAlternative(array $norm){		
		/*
		Print normalized
		*/
		echo '<div class="table-responsive">';
		echo "<table class='table table-bordered'>";
		$countAlt = count ($this->alternative_id);
		echo "<tr>";
		for ($j=0;$j<$countAlt;$j++){
			echo "<td>".$this->alternative_id[$j]."</td>";
		}
		echo "</tr>";
		
		$N = count($norm);
		for ($i=0;$i<$N;$i++){
			echo "<tr>";
			$v = count($norm[$i]);
			for ($j=0;$j<$v;$j++){
				echo "<td>".$norm[$i][$j]."</td>";
			}
			echo "<tr>";
		}
		echo "</table>";
		echo "</div>";
	}
	
	public function PrintPairWise(array $pw){
		$countCriteria = count($this->criteria);
		for ($c=0;$c<$countCriteria;$c++){
			echo "KRITERIA-$c : ". $this->criteria[$c]."<br>";
			echo '<div class="table-responsive">';
			echo "<table class='table table-bordered table-condensed'>";
			$N = count($pw[$c]);
			for ($i=0;$i<$N;$i++){
				echo "<tr>";
				$n = count($pw[$c][$i]);
				for ($j=0;$j<$n;$j++){
					echo "<td>";
					echo $pw[$c][$i][$j];
					echo "<td>";
				}
				echo "<tr>";
			}
			echo "</table>";
			echo "</div>";
		}
	}
	
	public function PrintAggregate(array $a){
		$countCriteria = count($this->criteria);
		for ($c=0;$c<$countCriteria;$c++){
			echo "KRITERIA-$c : ". $this->criteria[$c]."<br>";
			echo '<div class="table-responsive">';
			echo "<table class='table table-bordered table-condensed'>";
			$N = count($a[$c]);
			for ($i=0;$i<$N;$i++){
				echo "<tr>";
					echo "<td>";
					echo $a[$c][$i];
					echo "<td>";
				echo "<tr>";
			}
			echo "</table>";
			echo "</div>";
		}
	}
	
	public function PrintRanking(array $rank_result){		
		//$rank_result = array_map(null, $this->alternative_id,$this->ranking_result);
		echo '<div class="table-responsive">';
		echo "<table class='table table-bordered table-condensed'>";							
		$N = count($rank_result);				
		for ($i=0;$i<$N;$i++){
			echo "<tr><td>".$rank_result[$i][0]."</td><td>".$rank_result[$i][1]."</td><td>".$rank_result[$i][2]."</td></tr>";			
		}
		echo "</table>";	
		echo "</div>";	
	}	
}

