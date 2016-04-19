<!DOCTYPE html>
<html>
	
	<head>
		<script src="jquery-1.11.3.min.js"></script>
		<title>Sudoku solver</title>
		
		<style>
			table{
			border-collapse:collapse;
			background-color:white;
			}
			
			table td{
			border:1px solid black;
			width:18px;
			height:20px;
			text-align:center;
			}
			
			table tr:nth-child(3),
			table tr:nth-child(6){
			border-bottom:2px solid black;
			}
			
			table tr td:nth-child(3),
			table tr td:nth-child(6){
			border-right:2px solid black;
			}
			.input_cell{
			width:100%;
			border:none;
			text-align:center;
			outline: none;
			font-size:15px;
			}
			h1{
			padding:0;
			margin:0;
			}
			.conteiner{
			width:30%;
			margin:0 auto;
			text-align:center;
			background-color:#5353c6;
			padding:15px 0;
			}
			form,.answer{
			display:table;
			margin:0 auto;
			}
			.btn-1,.btn-2{
			width:40%;
			margin:15px 5px;
			}
		</style>
		<script>
			var sudokuSolver = function(){
				var arr = new Array();
				for(var i=1; i<=9; i++){
					arr[i] = new Array();
					for(var j=1; j<=9; j++){
						val = $('#cell_'+i+j).val();
						if(("123456789").indexOf(val) == -1){
							$('.answer').html("Wrong value</br>The fields should be filled by numbers from 1 to 9");
							return false;
						}
						if(val != "" && val != " ") arr[i][j] = val;
						
					}
				}
				var arrJson = JSON.stringify(arr);
				return arrJson;
			}
			var sudokuAjax = function (){
				var data = sudokuSolver();
				if(data){
					$.ajax({
						url:"sudoku.php",
						data:"num="+data,
						dataType:"html",
						success:function(response){
							$('.answer').html(response);
						}
					})
				}
			}
		</script>
	</head>	
	
	<body>
		<div class="conteiner">
			<h1>Sudoku solver</h1>
			<form name="sudoku">
				<table>
					<?php for($i=1;$i<=9;$i++):?>
					<tr>
						<?php for($j=1;$j<=9;$j++):?>
						<td>
							<?php	echo "<input type='text' name='cell_$i$j' id='cell_$i$j' class='input_cell' maxlength='1' min='1' max='9'>";?>
						</td>
						<?php endfor;?>
					</tr>
					<?php endfor;?>
				</table>
				<div class="btn-block">
					<input type="button" class="btn-1" name="sudoku_but" value="Solve" onclick="sudokuAjax()">
					<input type="reset" class="btn-2" value="Reset">
				</div>
			</form>
			<div class="answer"></div>
		</div>
	</body>
</html>		