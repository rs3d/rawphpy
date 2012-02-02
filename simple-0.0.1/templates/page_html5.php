<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="<?php echo $lang;?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?php echo $lang;?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?php echo $lang;?>"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="<?php echo $lang;?>" xml:lang="<?php echo $lang;?>">  <!--<![endif]-->
<head>
	<title><?php echo $title;?></title>
	<meta charset="utf-8" />
	<meta name="author" 		content="" />
	<meta name="keywords" 		content="<?php echo $title;?>" />
	<meta name="description" 	content="<?php echo $title;?>" />
	<meta name="robots" content="index, follow" />

	<link href="/css/<?php echo $css;?>" rel="stylesheet" media="all"  />
	<link rel="shortcut icon" href="/img/favicon.ico" />
	<link id="page_favicon" href="/img/favicon.ico" rel="icon" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="/js/jquery-1.6.2.min.js"></script>
	
	<script src="/js/script.js"></script>
</head>
<body <?php echo $class?>>
<div class="container"> 
<div id="page">
	
	<header>
		<hgroup class="section">
			<h1 id="logo">
				<a href="<?php echo $this -> makeViewLink('/')?>">
					Logo
				</a>
			</h1>
			<h2 id="claim" >
				Claim
			</h2>
		</hgroup>
	</header>
	<div id="layout">
		<div id="main" role="main" class="section">
			<div id="content">
		
			<h2 class="auto"><?php echo $title;?></h2>
			
			<?php
			show($lang);
			show($css);
			#echo $barrieren_test;
			#echo $uri_translated;
			#echo $BasePath;
			#show ($NavigationTemp -> parent_root)

			// Beispiel-Func view(array('content'=>$page, 'view'=>'default'));
			?>
		
			<?php
			echo $output;
			foreach ($content as $cont) {
				$file = $init['directories']['root'].BASE_PATH.'/_content/'.$cont;
				if (is_file($file)) include $file;
			}
			?>
		
			</div>
		</div>
	
		<nav id="navigation" class="section">
			<h4class="section">Navigation</h4>
			<ul>
				
				<li>
				<div id="navigation-main">
					<h4 class="section">Navigation</h4>
					<?php echo $navigation['main'];?>
				</div>
				</li>
				<li>
				<div id="navigation-context">
					<h4 class="section">Kontextnavigation</h4>
					<?php echo $navigation['context'];?>
				</div>
				</li>
				<li>
				<div id="navigation-breadcrumb">
					<h4 class="section">Breadcrumb</h4>
			 		<?php echo $navigation['breadcrumb'];?>
				</div>
				</li>
				<li>
				<div id="navigation-global">
					<h4 class="section">Globale Navigation</h4>
			 		<?php echo $navigation['global'];?>
				</div>
				</li>
			</ul>
		</nav>
	
		<footer id="footer" class="section">
		<p>&copy; <a href="<?php echo $this -> makeViewLink('/impressum')?>" title="Impressum/Kontakt">2011</a> </p>
		</footer>
	</div>
	</div>
</div>
</body>
</html>