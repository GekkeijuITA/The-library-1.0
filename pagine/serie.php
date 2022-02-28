<?php
    $serie = $_GET["serie"];
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Biblioteca - <?php echo $serie;?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    </header>
    <body> 
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">Biblioteca</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="biblioteca.php">Lista Libri</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="aggiungi.php">Aggiungi Libro</a>
                        </li>
                    </ul>               
                </div>
            </div>
        </nav>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-4 mt-3 ms-2 me-2 mb-3" id="scaffali">
            <?php 
            $percorsoFile = "../libri/biblioteca.xml";
                if(file_exists($percorsoFile))
                {
                    $fileXml = simplexml_load_file($percorsoFile);
                    foreach($fileXml -> children() as $series)
                    {
                        if($series['titolo'] == $serie)
                        {
                            $titolo = $serie;
                            foreach($series -> children() as $volumi)
                            {
                                $numero = $volumi['numero'];
                                $copertina = "../img/".$volumi[0]['copertina'];
                                echo '
                                <div class="col center '.strtolower($titolo).'">
                                    <div class="card w-100">
                                        <a href="spec.php?volume='.$numero.'&serie='.$titolo.'"><img src="'.$copertina.'" class="card-img-top h-100" alt="'.$titolo.$numero.'"></a>
                                        <div class="card-body">
                                            <h5 class="card-title">'.$titolo.' '.$numero.'</h5>
                                        </div>
                                    </div>
                                </div> ';
                            }
                        }
                    }        
                }
            ?> 
        </div>    
        <link rel="stylesheet" href="../css/mioStile.css">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body> 
</html>