<?php

session_start();


	if ($_SERVER["REQUEST_METHOD"] === "POST")
	{
		$db = mysqli_connect("localhost:5222", "root", "", "test");
	
		if (!$db)
			die('Conectare esuata: ' . mysqli_connect_error ());
		echo 'Conectare reusita';

		if (isset($_POST["audioData"]))
		{
			echo "TOTUL E OK";
		
			$voce = $_POST["audioData"];
			$voce = mysqli_real_escape_string($db, $voce);
		
			$interogare = "INSERT INTO tabel_audio_samples (semnal) VALUES (\"$voce\");";
		
			mysqli_query($db, $interogare);

			if (mysqli_errno($db))
				die('<br>Adaugare esuata: ' . mysqli_errno($db) . ": " . mysqli_error($db) . "<BR>");
		}

		if (isset($_FILES["audioData"]) && $_FILES["audioData"]["error"] === UPLOAD_ERR_OK)
		{
			echo "TOTUL E OK";
		
			$voce = file_get_contents($_FILES["audioData"]["tmp_name"]);
			$voce = mysqli_real_escape_string($db, $voce);
			
			$interogare = "INSERT INTO tabel_audio_samples (semnal) VALUES (\"$voce\");";

			mysqli_query($db, $interogare);

			if (mysqli_errno($db))
				die('<br>Adaugare esuata: ' . mysqli_errno($db) . ": " . mysqli_error($db) . "<BR>");

			mysqli_close($db);
		}
		else
			echo "Error uploading the file.";

		echo "<br>";
	}


	
	$pythonExecutable = "C:/Users/Liuda/anaconda3/python.exe";
	$scriptPath = "aplicare_algoritm.py";
	
	$command = "$pythonExecutable $scriptPath 2>&1";
	
	exec($command,$output, $returnVar);
	
	
	//if ($returnVar === 0) {
	//		echo "Python script executed successfully.<br>";
	//		print_r($output);
	//} else {
	//	echo "Error executing Python script. Details:";
	//	print_r($output);
	//}
	
	// Remove the following two lines for debugging
	header("Location: pag4.php");
	exit;