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
                display: block; /* Set the button to block level */
                margin: 20px auto; /* Center the button horizontally */
            }
            button:hover {
                background-color: #0c7ca8;
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

                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">
                            <?php
$db = mysqli_connect("localhost:5222", "root", "", "test");
if(!$db)
    die('Conectare esuata: ' . mysqli_connect_error ());
$interogare = "SELECT rezultat FROM tabel_audio_samples ORDER BY id DESC LIMIT 1";

$raspuns = mysqli_query($db, $interogare);

if (mysqli_errno($db)) 
    die('<br>'.mysqli_errno($db).": ".mysqli_error($db)."<br>");

$N = mysqli_affected_rows($db);

if($N > 0)
{
    $linie = mysqli_fetch_row($raspuns);
    $rezultat = $linie[0];
    if($rezultat === NULL) {
        echo "Ceva nu a mers bine. Te rugăm să încerci din nou.";
    } else {
        // Semnificații pentru fiecare valoare posibilă
        switch ($rezultat) {
            case 0:
                echo "A fost detectata o emotie POZITIVA";
                break;
            case 1:
                echo "A fost detectata o emotie NEUTRA";
                break;
            case 2:
                echo "A fost detectata o emotie NEGATIVA";
                break;

            default:
                echo "Rezultatul nu este cunoscut.";
                break;
        }
    }
}
else {
    echo "Ceva nu a mers bine. Te rugăm să încerci din nou.";
}

mysqli_close($db);
?>



                            </h1>
                            <br><br>
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
                            <h6>Institutul National <br> de Cercetare Dezvoltare<br> in Informatica <br> ICI Bucuresti</h6>
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


