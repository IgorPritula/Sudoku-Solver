<?php
	
	//class contains methods that can be used to solve Sudoku
	class sudoku{
		public $arr;
		
		public $new_arr;
		
		public $arr_pos_val;
		
		//construct fills an array of received values from user
		//and checks the validity of
		function __construct($num){
			$arr = array();
			for($i=1; $i<=9; $i++){
				$arr[$i]=array();
				for($j=1;$j<=9;$j++){
					if(isset($num[$i][$j]))
					$arr[$i][$j] = intval($num[$i][$j]);
					else $arr[$i][$j] = false;
				}
			}
			$this->arr = $arr;
			$this->new_arr = $arr;
			$this->validate();
		}
		
		//validation of incoming data
		//if user enters the same numbers in the same row, column or square will be generated an error
		protected function validate(){
			for($i=1;$i<=9;$i++){
				$num = array();
				foreach($this->arr[$i] as $val){
					if($val) $num[] = $val;
				}
				$new_num = array_unique($num);
				if($new_num != $num)die("Mistake, several identical numbers in one row");
			}
			
			for($i=1;$i<=9;$i++){
				$num = array();
				foreach($this->arr as $val){
					if($val[$i]) $num[] = $val[$i];
				}
				$new_num = array_unique($num);
				if($new_num != $num)die("Mistake, several identical number in one column");
			}
			for($i=1;$i<=9;$i++){
				$num = $this->square_val(0,0,$i);
				$new_num = array_unique($num);
				if($new_num != $num)die("Mistake, several identical number in one square");
			}
		}
		//returns the numbers from square
		//for arguments takes the coordinates of a cell or a square number(if known in advance square number)
		public function square_val($Y,$X,$n = null){
			$arr = $this->new_arr;
			if($n == null)$n = $this->square_num($Y,$X);
			
			$sq_num = array(1=>[1,1],2=>[1,4],3=>[1,7],4=>[4,1],5=>[4,4],6=>[4,7],7=>[7,1],8=>[7,4],9=>[7,7]);
			$val = array();
			
			for($y=$sq_num[$n][0],$i=1;$i<=3;$i++,$y++){
				for($x=$sq_num[$n][1],$j=1;$j<=3;$j++,$x++){
					if($arr[$y][$x]){
						$val[] = $arr[$y][$x];
					}
				}
			}
			return $val;
		}
		//method returns an array of arrays with all possible values of each cell in a certain square
		//each inner array contains valid cell values
		//for arguments takes the coordinates of a cell 
		public function perfect_value($ym,$xm){
			$n = $this->square_num($ym,$xm);
			$sq_num = array(1=>[1,1],2=>[1,4],3=>[1,7],4=>[4,1],5=>[4,4],6=>[4,7],7=>[7,1],8=>[7,4],9=>[7,7]);
			$arr_values = array();
			
			for($y=$sq_num[$n][0],$i=1;$i<=3;$i++,$y++){
				for($x=$sq_num[$n][1],$j=1;$j<=3;$j++,$x++){
					
					if($ym == $y && $xm == $x)continue;
					
					if(!$this->arr[$y][$x]){
						$pos_val = $this->possible_value($y,$x);
						$arr_values[] = $pos_val;
					}
				}
			}
			
			
			return $arr_values;
		} 
		
		//method returns an array of arrays with all possible values of each cell in a certain horizontal
		//each inner array contains valid cell values
		//for arguments takes the coordinates of a cell 
		public function perfect_horizon_value($y,$x){
			$arr_values = array();
			
			foreach($this->new_arr[$y] as $key => $val){
				if(!$val && $key!=$x){
					
					$pos_val = $this->possible_value($y,$key);
					$arr_values[] = $pos_val;
					
					
				}
			}
			return $arr_values;
		}
		
		//method returns an array of arrays with all possible values of each cell in a certain vertical
		//each inner array contains valid cell values
		//for arguments takes the coordinates of a cell 
		public function perfect_vertical_value($y,$x){
			$arr_values = array();
			
			foreach($this->new_arr as $key => $val){
				if(!$this->new_arr[$key][$x] && $key!=$y ){
					$pos_val = $this->possible_value($key,$x);
					$arr_values[] = $pos_val;
				}
			}
			
			return $arr_values;
		}
		
		//returns the number of the inner square using coordinates of the cell
		public function square_num($y,$x){
			$Y = 1;
			$X = 1;
			$num = array(array(1,2,3),array(4,5,6),array(7,8,9));
			if($y>=1 && $y<=3){
				$Y = 0;
			}
			if($y>=4 && $y<=6){
				$Y = 1;
			}
			if($y>=7 && $y<=9){
				$Y = 2;
			}
			
			if($x>=1 && $x<=3){
				$X = 0;
			}
			if($x>=4 && $x<=6){
				$X = 1;
			}
			if($x>=7 && $x<=9){
				$X = 2;
			}
			return $num[$Y][$X];
		}
		
		//It returns the possible horizontal and vertical values of the specific cell
		public function horizon_vertical_val($y,$x){
			$arr = $this->new_arr;
			$num = array();
			foreach($arr[$y] as $val){
				if($val) 
				$num[] = $val;
			}
			foreach($arr as $val){
				if($val[$x]) 
				$num[] = $val[$x];
			}
			return array_unique($num);	
		}
		//returns ALL possible values of the cell
		public function possible_value($y,$x){
			
			$sq = $this->square_val($y,$x);
			$line = $this->horizon_vertical_val($y,$x);
			$val = array_unique(array_merge($sq,$line));
			$values = array(1,2,3,4,5,6,7,8,9);
			$values = array_diff($values,$val);
			return $values;
		}
		//displays on the screen Sudoku
		public function printout($arr = 0){
			$arr = $arr ? $arr : $this->new_arr;
			echo "<table>";
			foreach($arr as $valx){
				echo "<tr>";
				foreach($valx as $valy){
					echo "<td>".$valy."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	
	
	
	
	
	function preGo($num){
		$sudoku = new sudoku($num);
		$num = $sudoku->arr;
		$pos_val=array();
		foreach($sudoku->arr as $Y => $yval){
			
			foreach($yval as $X => $xval){
				if(!$sudoku->arr[$Y][$X]){
					
					$all_pos_val = array();
					$pos_val = $sudoku->possible_value($Y,$X);
					if(count($pos_val)==1){
						$sudoku->new_arr[$Y][$X] = current($pos_val);
						continue;
					}
					
					$arr_pos_val = $sudoku->perfect_value($Y,$X);
					
					foreach($arr_pos_val as $arr1){
						$all_pos_val+=$arr1;
					}
					
					$val = array_diff($pos_val,$all_pos_val);
					
					if($val){
						$sudoku->new_arr[$Y][$X] = current($val);
						
						continue;
					}
					/*------*/
					
					$all_pos_val = array();
					$arr_pos_val = $sudoku->perfect_horizon_value($Y,$X);
					
					foreach($arr_pos_val as $arr1){
						$all_pos_val+=$arr1;
					}
					$val = array_diff($pos_val,$all_pos_val);
					if($val){
						$sudoku->new_arr[$Y][$X] = current($val);
						
						continue;
					}
					
					/*------*/
					$all_pos_val = array();
					$arr_pos_val = $sudoku->perfect_vertical_value($Y,$X);
					
					foreach($arr_pos_val as $arr1){
						$all_pos_val+=$arr1;
					}
					$val = array_diff($pos_val,$all_pos_val);
					if($val){
						
						$sudoku->new_arr[$Y][$X] = current($val);
						
						
						continue;
					}
					
					
				}
				
			}
			
		}
		return $sudoku->new_arr;
	}
	
	
	
	function gogo($num){
		$sudoku = new sudoku($num);
		
		$pos_val=array();
		
		$error = false;
		$newArr = $sudoku->arr;
		$backStep = false;
		$backjump = false;
		for($y=1; $y<=9; $y++){
			
			
			
			
			for($x=1; $x<=9; $x++){
				
				if($backjump){
					
					$x=9;
					
					$backjump = false;
				}
				
				
				
				if(!$sudoku->arr[$y][$x]){
					
					
					if($backStep){
						array_shift($sudoku->arr_pos_val[$y][$x]);
						
						$backStep = false;
					}
					else{
						$pos_val = $sudoku->possible_value($y,$x);
						$sudoku->arr_pos_val[$y][$x] = $pos_val;
					}
					
					if($y<1 || $x<1){
						$error = "There is no right answer!";
						break 2;
					}
					
					if(!$sudoku->arr_pos_val[$y][$x] && $x!=1){
						
						$sudoku->new_arr[$y][$x] = null;
						$x-=2;
						
						$backStep = true;
						continue;
					}
					elseif(!$sudoku->arr_pos_val[$y][$x] && $x==1){
						$sudoku->new_arr[$y][$x] = null;
						$backStep = true;
						
						break;
					}
					
					
					$sudoku->new_arr[$y][$x] = current($sudoku->arr_pos_val[$y][$x]);
				}
				elseif($sudoku->arr[$y][$x] && $backStep && $x!=1){
					
					$x-=2;
				}
				elseif($sudoku->arr[$y][$x] && $backStep && $x==1){
					break;
				}
			}
			
			if($backStep){
				$y-=2;
				$backjump = true;
			} 
			
		}
		if($error){
			echo $error;
		}
		else{ 
			$sudoku->printout($sudoku->new_arr);
		}
	}
	
	/* $num = [1 => [8 => 5], 
		2 => [6 => 6, 7=>8], 
		3 => [3 => 2, 8=>6], 
		4 => [1=>1],
		5 => [2=>5,9=>9],
		6 => [4 => 2, 6=>7, 9=>4],
		8 => [2 => 1, 5=>5, 6=>8],
	9 => [3 => 3, 8=>1, 9=>2]]; */
	
	$sudoku;
	$num = array();
	
	if(isset($_GET["num"])){
		$num = json_decode($_GET["num"]);
		$sudoku = new sudoku($num);
		
		$var = true;
		$arr = array();
		
		while($var){
			$arr = preGo($num);
			if($num === $arr)$var = false;
			$num = $arr;
		}
		
		
		gogo($num);
	}
?>
