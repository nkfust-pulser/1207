<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	
</body>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type='text/javascript'></script>
<script>
	$.ajax({
		type: 'GET',
		url: 'fromPython.php',
		dataType: "json",  
		success: function(data) {
			$.post("peaksToDatabase.php",{index:data[1],number:data[2],value:data[3]}
			,function(data2){
				console.log(data2);
			});
		},
		error: function() {
			alert("ERROR");
		}
	});

</script>
</html>