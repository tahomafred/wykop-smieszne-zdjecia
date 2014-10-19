<!DOCTYPE html>
<html lang="pl">
<head>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel="stylesheet" href="css/style.css">
	<meta charset="UTF-8">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
			</button>
			<a class="navbar-brand" href="#">Wykop Śmieszne Zdjęcia</a>
		</div>
		<form method="post">
			<?php /*echo ('<input type="submit" value="' . $pageC . '" placeholder="Następna strona" class="btn btn-default">'); */?>
		</form>
		<form class="navbar-form navbar-right" id="tag-form">
			<div class="form-group">
				<input type="text" id="tag-form-name" class="form-control" name="tag" placeholder="Wpisz Nazwę #tagu">
				<input type="submit" class="btn btn-default">
			</div>
		</form>
	</div>
</nav>
<div class="container" id="img-container">
	<?php echo $imgHtml ?>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/imgloader.js"></script>
</body>
</html>