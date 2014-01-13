<!-- David Errico-Nagar
 Web Programming
 This is a PHP file that creates a "rotten tomatoes"-esque web page for a number of movies-->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Rancid Tomatoes</title>
		<link href="movie.css" type="text/css" rel="stylesheet" />
		<link href="http://ycfac197.mc.yu.edu/COM3780/12fa/homework/2/rotten.gif" 
		type="image/gif" rel="shortcut icon" />
	</head>
	<body>
		<?php $film = $_GET["film"] /* this gets the film */?>
		<div id="header">
			<img src="http://ycfac197.mc.yu.edu/COM3780/12fa/homework/2/banner.png" alt="banner" />
		</div>
		<h1><?php
			/* Here we produce the film info on the top by taking the first and second line of the 
			file "info" */
			$info = file("{$film}/info.txt", FILE_IGNORE_NEW_LINES); 
			echo $info[0]." (".$info[1].")"; 
		?></h1>
		<div id=outerbox>
			<div id=overview>
				<div>
					<img src="<?= $film ?>/overview.png" alt="overviewg" />
				</div>
				<dl>
					<?php 
						/* this takes the overview file and breaks it up into a definition 
						list to create the sidebar */
						$overview = file("{$film}/overview.txt", FILE_IGNORE_NEW_LINES);
						foreach($overview as $d) {
							$d1 = explode(":", $d); 
							?>
							<dt><?= $d1[0]?> </dt>
							<?php for($i=1; $i<count($d1); $i++){ ?>
								<dd><?= $d1[$i] ?></dd>
								<?php
							}
						}
					?>
				</dl>
			</div>
		<div id=reviews>
			<div id=banner>
			<?php
			/* I used an if-else statement since the decision to display FRESH or ROTTEN
			is dependent on the overall score it received*/
			$big_image = "";
			if($info[2]>=60) {
				$big_image="freshbig.png";
			}
			else{
				$big_image="rottenbig.png";
			}
			?>
			<img src="http://ycfac197.mc.yu.edu/COM3780/12fa/homework/2/<?= $big_image ?>" alt="Rotten" />
			<?= $info[2] ?>% <!-- this gets the percentage from the info.txt file -->
			</div>
			<?php
			/* Here the reviews are produced by creating an array of file paths for each review, 
			and then pulling each file and producing the requisite code to make a review that 
			aligns with the CSS file. Additionally, the code decides where to break the reviews 
			into two divs--if the number of reviews is even it breaks in the middle; if it is odd, 
			then the extra one goes in the left column. this shortens the code by a lot.*/
			$reviews=glob("{$film}/review*.txt");
			$N = count($reviews);
			$half=((int)($N/2)+$N%2);
			for($i=0; $i<$N; $i++){
				if($i==$half or $i==0) { ?>
					<div class=revcol>
				<?php } ?>
				<?php
				$review=file($reviews[$i], FILE_IGNORE_NEW_LINES);
				?>
				<p>
				<?php
				if($review[1] == "FRESH"){ ?>
					<img src="http://ycfac197.mc.yu.edu/COM3780/12fa/homework/2/fresh.gif" 
					alt="Fresh" />
					<?php
				}
				else{ ?>
					<img src="http://ycfac197.mc.yu.edu/COM3780/12fa/homework/2/rotten.gif" 
					alt="Rotten" />
					<?
				}
				?>
				<q><?= $review[0] ?></q>
				</p>
				<p>
				<img src="http://ycfac197.mc.yu.edu/COM3780/12fa/homework/2/critic.gif" 
				alt="Critic" />
				<?= "$review[2]" ?> <br />
				<?= "$review[3]" ?>
				</p>
				<?php
				if($i==($half-1) or $i==$N) { ?>
					</div>
				<?php } ?>
			<?php
			}
			?> 
			</div>
		</div>
		<div id=footer>
			<p>(1-<?= $N ?>) of <?= $N ?></p>
		</div>
		</div>
		<div id=validators>
			<a href="https://webster.cs.washington.edu/validate-html.php"><img 
			src="http://webster.cs.washington.edu/w3c-html.png" alt="Valid HTML5" /></a> <br />
			<a href="https://webster.cs.washington.edu/validate-css.php"><img 
			src="http://webster.cs.washington.edu/w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</body>
</html>