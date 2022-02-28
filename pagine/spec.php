<?php
    $numero = $_GET["volume"];
    $serie = $_GET["serie"];
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Biblioteca</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    </header>
    <body> 
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fill">
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
        <div id="scaffale">
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
                                $numeroXml = $volumi['numero'];
                                if($numeroXml == $numero)
                                {
                                    $copertina = "../img/".$volumi['copertina'];
                                    $prezzo = $volumi['prezzo'];
                                    echo '
                                    <img src="'.$copertina.'" class="mt-2 ms-2" alt="'.$titolo.$numero.'">
                                    <div id="descrizione">
                                        <h1>'.$titolo.' '.$numero.'</h1>
                                        <h3>Prezzo: € '.$prezzo.'</h3>
                                        <h3>Casa Editrice: '.$series['casaEditrice'].'</h3>
                                    </div>
                                    ';
                                    break;
                                }
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