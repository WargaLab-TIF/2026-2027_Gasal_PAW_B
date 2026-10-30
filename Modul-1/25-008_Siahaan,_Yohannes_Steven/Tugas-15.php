<html>
<head>
	
</head>
<body>
	<?php
		function familyName ($fname, $fyear) {
			return $fname . " born in " . $fyear . "<br>";
		}

		echo familyName("Hege", 1975);
		echo familyName("Stale", 1978);
		echo familyName("Kai Jim", 1983);
	?>
</body>
</html>