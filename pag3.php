<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>EmoMonitor</title>
        <style>
            button {
                font-family: 'Lato', sans-serif;
                font-size: 24px;
                background-color: #80d0c7;
                color: rgb(221, 237, 248);
                border: none;
                border-radius: 15px;
                padding: 16px 32px;
                cursor: pointer;
                display: block;
            }
            button:hover {
                background-color: #0c7ca8;
            } 
            .button-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 20px; /* Adjust as needed */
            }   
        </style>   
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/templatemo-topic-listing.css" rel="stylesheet">      
    
    </head>
    
    <body id="top">

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="index.html">
                        <img src="images/download.png" style="width: 60px; height: 50px;">
                        <span>EmoMonitor</span>
                    </a>
                </div>
            </nav>
            

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">

                    <div class="col-lg-8 col-12 mx-auto" style="text-align: center;">
                          <h2 class="text-white text-center">Înregistrează-ți vocea, în timp ce citești următorul text:<br></h2>
                          <br><br>
                          <h3 id="txt" style="color:black;text-align:justify;">
                             &nbsp &nbsp &nbsp &nbsp
                            <?php
                              $v="Kids are talking by the door and Dogs are sitting by the door";
                              echo $v;
                            ?>
                          </h3>
                          <br>
                         <div class="button-container">
                             <button id="recordButton" type="button">Start</button>
                         </div>
                         <p id="seinreg" style="display:none;font-size:18px;color:black;"><br><br>Se înregistrează...începe să vorbești!</p>
                         <br><br>
                         <audio id="audioPlayer" controls style="display: none;"></audio>
                         <br><br>
                         <button id="uploadButton" type="button" style="display: none">Încarcă</button>
                     </div>


<script>
    let mediaRecorder;
    let recordedChunks = [];
	let blob;

    // Get user media (audio) stream
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(function(stream) {
            // Create a new MediaRecorder
            mediaRecorder = new MediaRecorder(stream);

            // Event handler when data is available
            mediaRecorder.ondataavailable = function(event) {
                recordedChunks.push(event.data);
            };

            // Event handler when recording stops
            mediaRecorder.onstop = function() {
                blob = new Blob(recordedChunks, { type: 'audio/wav' });
                recordedChunks = [];

                // Create a URL for the recorded audio
                let audioURL = URL.createObjectURL(blob);

                // Show the audio player
                document.getElementById('audioPlayer').style.display = 'inline';

                // Set the audio source to the recorded audio
                document.getElementById('audioPlayer').src = audioURL;
				
				document.getElementById('uploadButton').style.display = 'inline';
                };

                // Event handler when record button is clicked
                document.getElementById('recordButton').addEventListener('click', function() {
                    if (mediaRecorder.state === 'inactive') {
						let audioPlayer = document.getElementById('audioPlayer');
						audioPlayer.pause();
						audioPlayer.currentTime = 0;
						
                        mediaRecorder.start();
                        this.textContent = 'Stop';
						document.getElementById('seinreg').style.display = 'inline';
						document.getElementById('audioPlayer').style.display = 'none';
						document.getElementById('uploadButton').style.display = 'none';
                    }
					else {
                        mediaRecorder.stop();
                        this.textContent = 'Încearcă din nou';
						document.getElementById('seinreg').style.display = 'none';
                    }
					
                });
				// Event handler when upload button is clicked
				document.getElementById('uploadButton').addEventListener('click', function() {					
					// Create a FormData object to send the audio data to PHP
					const formData = new FormData();
					formData.append('audioData', blob);

					// Use AJAX to send the form data to the PHP script
					const request = new XMLHttpRequest();
					request.open('POST', 'upload.php');
					request.send(formData);
					
					window.location.href = 'upload.php';

				});
        })
		.catch(function(err) {
            console.error('Error accessing the microphone: ', err);
        });
</script>
                        </div>

                    </div>
                </div>
            </section>


            <section class="featured-section">
                <div class="container">
                </div>
            </section>
        </main>

<footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="https://www.ici.ro/ro/">
                            <div style="text-align: center;">
                                <img src="images/logo-ici.png" style="width: 65px; height: 50px;"> <br> 
                            <h6>Institutul National <br>de Cercetare Dezvoltare<br> in Informatica <br> ICI Bucuresti</h6>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Resurse</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Home</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Informatii</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: 305-240-9671" class="site-footer-link">
                                021 316 5262
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:info@company.com" class="site-footer-link">
                                office@ici.ro
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>


        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
