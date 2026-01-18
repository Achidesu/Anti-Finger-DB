<?php

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, "https://api.sheetbest.com/sheets/eb063465-9a3d-49c9-9922-76fde01f3c24"); //paste api link
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $output = curl_exec($ch);
   curl_close($ch); 

   //change to array format
   $result = json_decode($output);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<title>Anti Finger Database.</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Anti Finger Database.</h2>
	<table id="data">
            <thead>
		<tr>
			<th>id</th>
			<th>Date</th>
			<th>Machine_ID</th>
			<th>Data</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php if(!empty($result)) : ?>
			<?php foreach($result as $key => $value): ?>
			<tr>
				<td><?php echo $value->id; ?></td>
				<td><?php echo $value->Date; ?></td>
				<td><?php echo $value->Machine_ID; ?></td>
				<td><?php echo $value->Data; ?></td>
				<td> 
					<button onclick="deleteRow('<?php echo $value->id; ?>')" class="btn btn-danger mt-2">Delete</button>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	    </tbody>
        </table>
</body>
<script>
	function deleteRow(id) {
		if (!confirm("Are you sure you want to delete ID: " + id + "?")) {
			return; 
		}
		const url = `https://api.sheetbest.com/sheets/eb063465-9a3d-49c9-9922-76fde01f3c24/id/*${id}*`;

		fetch(url, {
			method: "DELETE",
		})
		.then((response) => response.json())
		.then((data) => {
			console.log("Success:", data);
			alert("Deleted successfully!");
			location.reload();
		})
		.catch((error) => {
			console.error("Error:", error);
			alert("Delete failed. Check console for details.");
		});
	}
</script>
</html>
