<!DOCTYPE html>
<html>
    <header>
        <title>Biblioteca</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="css/bootstrap.min.css"> 
    </header>
    <body> 
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Biblioteca</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-fill">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="pagine/biblioteca.php">Lista Libri</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="pagine/aggiungi.php">Aggiungi Libro</a>
                    </li>
                </ul>                
                </div>
            </div>
        </nav>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-4 mt-1 ms-2 me-2 mb-1" id="scaffali">
            <?php
            $percorsoFile = "libri/biblioteca.xml";
                if(file_exists($percorsoFile))
                {
                    $fileXml = simplexml_load_file($percorsoFile);
                    $numSerie = $fileXml -> count();
                    $serie = $fileXml -> children();
                    for($i = 0 ; $i < $numSerie ; $i++)
                    {
                        $titolo = $serie[$i]['titolo'];
                        $volume = $serie[$i] -> children();
                        $copertina = "img/".$volume[0]['copertina'];
                        echo '
                        <div class="col center scaffale '.strtolower($titolo).'">
                            <div class="card w-100">
                                <a href="pagine/serie.php?serie='.$titolo.'"><img src="'.$copertina.'" class="card-img-top" alt="'.$titolo.'"></a>
                                <div class="card-body">
                                    <h5 class="card-title" style="color:white;">'.$titolo.'</h5>
                                </div>
                            </div>
                        </div> ';               
                    }          
                }
            ?> 
        </div>    
        <link rel="stylesheet" href="css/mioStile.css">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mioJs.js"></script>
    </body> 
</html>