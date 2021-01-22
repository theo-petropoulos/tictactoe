<?php
	require_once('php/functions.php');
	require_once('php/classes.php');

	session_start();
	$page= $_SERVER['PHP_SELF'];

	if(isset($_POST['reset']) && $_POST['reset']==1){
		session_destroy();
		header("Refresh: 0; url=$page");
	}

	if(isset($_POST['new_game']) && $_POST['new_game']==1){
		$_SESSION['ingame']=1;
		$_SESSION['play_count']=0;
		for($i=0;$i<9;$i++){
			$_SESSION['case'][$i]= new gameCase();
		}
	}

	if(isset($_POST['select_case']) && in_array($_POST['select_case'],range(0,8))){
		play_move($_SESSION['case'][$_POST['select_case']], $_SESSION['play_count']);
		$_SESSION['play_count']++;
		verify_game($_SESSION['case']);
	}

?>

<!DOCTYPE html>

<html>

	<head>
		<title>Tic Tac Toe</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type='text/css' href="css/tictactoecss.css?v=<?php echo time(); ?>">
		<link rel="icon" href="" />
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
	</head>

	<body>
		<header>
			<h1>Tic-Tac-Toe</h1>
			<h2>Blablabla</h2>
		</header>

		<main>
			<?php
			if(isset($_SESSION['ingame']) && $_SESSION['ingame']==1){?>
				<table>
					<tbody>
					<?php 
						$j=0;
						for($i=0;$i<3;$i++){
						?><tr>
							<?php for($j;$j<3*($i+1);$j++){
								?><td>
									<form action="index.php" method="post">
										<input type="hidden" name="select_case" value="<?php echo $j;?>">
										<input type="hidden" name="case_value" 
										value="<?php echo $_SESSION['case'][$j]->getValue();?>">
										<input type="submit" 
										value="<?php echo $_SESSION['case'][$j]->getValue();?>"
										<?php
										if($_SESSION['case'][$j]->getState()=='played'){
											?> disabled <?php
										} ?>
										>
									</form>
								</td>
							<?php } ?>
						</tr>
						<?php
					}?>
					</tbody>
				</table>
				<form action="index.php" method="post">
					<input type="hidden" name="reset" value="1">
					<input type="submit" value="Reset">
				</form>
				<?php
			}
			else{
				?><p>Jouer ?</p>
				<form action="index.php" method="post">
					<input type="hidden" name="new_game" value="1">
					<input type="submit" value="Go">
				</form>
			<?php } ?>
		</main>


		<footer>
		</footer>
	</body>

</html>