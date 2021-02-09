<?php
	require_once('php/functions.php');
	require_once('php/classes.php');

	session_start();
	$page= $_SERVER['PHP_SELF'];

	//Si l'utilisateur veut réinitialiser le plateau
	if(isset($_POST['reset']) && $_POST['reset']==1){
		session_destroy();
		header("Refresh: 0; url=$page");
	}

	//Si l'utilisateur veut commencer une nouvelle partie
	if(isset($_POST['new_game']) && $_POST['new_game']==1){
		//On initialise une variable "ingame"
		$_SESSION['ingame']=1;
		//On initialise le compteur de coups à 0
		$_SESSION['play_count']=0;
		//On génère les cases du morpion en session
		for($i=0;$i<9;$i++){
			$_SESSION['box'][$i]= new gameBox();
		}
		//On récupère la "mémoire" de l'IA et on créé l'IA
		$memory=file_get_contents('allGameRecords.ndjson');
		$_SESSION['AI']=new AI($memory, $_SESSION['box']);
	}

	//Si l'utilisateur choisit une case
	if(isset($_POST['select_box']) && in_array($_POST['select_box'],range(0,8))){
		//On joue le coup de l'utilisateur
		play_move($_SESSION['box'][$_POST['select_box']], $_SESSION['play_count']);
		//On initialise la string à rentrer en mémoire de l'IA
		$str='[';
		//On parcourt les cases pour récupérer leur état à l'instant T
		for($i=0;$i<9;$i++){
			$str.=$_SESSION['box'][$i]->getValue();
		}
		//On ferme la string à rentrer en mémoire, et on l'ajoute à un fichier temporaire
		$str.=']' . PHP_EOL;
		file_put_contents('currGameRecord.ndjson', $str, FILE_APPEND);
		$game_record=file_get_contents('currGameRecord.ndjson');

		//On vérifie l'état de la partie
		//Si la partie est terminée, on initialise la variable "endgame"
		//On créé une variable reprenant le fichier temporaire à insérer dans la mémoire de l'IA
		//On insère cette variable dans la mémoire
		if(verify_game($_SESSION['box'], $game_record, $_SESSION['play_count'])){
			$_SESSION['endgame']=1;
			file_put_contents('allGameRecords.ndjson', $game_record, FILE_APPEND);
			file_put_contents('currGameRecord.ndjson', '');
		}
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
										<input type="hidden" name="select_box" value="<?php echo $j;?>">
										<input type="hidden" name="box_value" 
										value="<?php echo $_SESSION['box'][$j]->getValue();?>">
										<input type="submit" 
										value="<?php echo $_SESSION['box'][$j]->getValue();?>"
										<?php
										if(
											$_SESSION['box'][$j]->getState()=='played' || 
											(isset($_SESSION['endgame']) && $_SESSION['endgame']==1)
										){
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