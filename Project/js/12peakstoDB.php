<script>
	$.ajax({
		type: 'GET',
		url: 'fromPython.php',
		dataType: "json",  
		success: function(data) {
			$.post("peaksToDatabase.php",{index:data[1],number:data[2],vaule:data[3]}
			,function(data2){
				console.log(data2);
			});
		},
		error: function() {
			alert("ERROR");
		}
	});

</script>