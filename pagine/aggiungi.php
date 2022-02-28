<?php
    $editoreSbagliato = FALSE;
    $duplicato = FALSE;
    if(isset($_POST["submit"]))
    {
        $titolo = $_POST["titolo"];
        $numVolume = $_POST["volume"];
        $ext = (pathinfo($_FILES['foto']['name']))['extension'];
        $folder =strtolower(str_replace(' ' , '' , $titolo)).$numVolume.'.'.$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'] , "../img/".$folder);

        $titolo = ucfirst(strtolower($titolo));
        $casaEditrice = $_POST["casaEditrice"];
        $dataAcquisto = $_POST["dataAcquisto"];
        $prezzo = $_POST["prezzo"];

        $percorsoFile = "../libri/biblioteca.xml";
        $esisteSerie = FALSE;
        if(file_exists($percorsoFile))
        {
            $simplefileXml = simplexml_load_file($percorsoFile);
            foreach($simplefileXml -> children() as $serie)
            {
                if($serie['titolo'] == $titolo)
                {
                    $esisteSerie = TRUE;
                }
            }          
        }
        else
        {
            $fileXml = new DOMDocument("1.0" , "utf-8");
            $fileXml -> formatOutput = true;
            $fileXml -> preserveWhiteSpace = false;
            $biblioteca = $fileXml -> createElement("biblioteca");
            $fileXml -> appendChild($biblioteca);
        }

        $fileXml = new DOMDocument("1.0" , "utf-8");
        $fileXml -> formatOutput = true;
        $fileXml -> preserveWhiteSpace = false;
        $fileXml -> load($percorsoFile);   

        if($esisteSerie)
        {
        foreach($simplefileXml -> children() as $serie){
            if($serie['titolo'] == $titolo)
            {
                foreach($serie -> children() as $volumi)
                {
                    if($volumi['numero'] == $numVolume)
                    {
                        $duplicato = TRUE;
                        break;
                    }
                    else
                    {
                        if($serie['casaEditrice'] != $casaEditrice)
                        {
                            $editoreSbagliato = TRUE;
                            break;
                        }

                        $simpleVolume = $serie -> addChild("volume");
                        $simpleVolume -> addAttribute("dataAcquisto" , $dataAcquisto);
                        $simpleVolume -> addAttribute("copertina" , $folder);
                        $simpleVolume -> addAttribute("prezzo" , $prezzo);
                        $simpleVolume -> addAttribute("numero" , $numVolume);
                        $fileXml -> loadXML($simplefileXml -> asXML());
                        break;
                    }
                }
            }
        }
        }
        else
        {           
            $serie = $fileXml -> createElement("serie");
            $titoloXml = $fileXml -> createAttribute("titolo");
            $titoloXml -> value = $titolo;
            $serie -> appendChild($titoloXml);

            $casaEditriceXml = $fileXml -> createAttribute("casaEditrice");
            $casaEditriceXml -> value = $casaEditrice;
            $serie -> appendChild($casaEditriceXml);

            $volume = $fileXml -> createElement("volume");
            $dataAcquistoXml = $fileXml -> createAttribute("dataAcquisto");
            $dataAcquistoXml -> value = $dataAcquisto;
            $volume -> appendChild($dataAcquistoXml);

            $fotoXml = $fileXml -> createAttribute("copertina");
            $fotoXml -> value = $folder;
            $volume -> appendChild($fotoXml);

            $prezzoXml = $fileXml -> createAttribute("prezzo");
            $prezzoXml -> value = $prezzo;
            $volume -> appendChild($prezzoXml);

            $numVolumeXml = $fileXml -> createAttribute("numero");
            $numVolumeXml -> value = $numVolume;
            $volume -> appendChild($numVolumeXml);

            $serie -> appendChild($volume);
            

            $fileXml -> documentElement -> appendChild($serie);
        }
        $fileXml -> save($percorsoFile);
    }
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Biblioteca</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="../css/bootstrap.min.css">  
        <link rel="stylesheet" href="../css/mioStile.css">       
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
        <div class="center mt-2">
            <div class="center">
                <form class="menu" method="post" action="" enctype="multipart/form-data">
                    <input type="text" name="titolo" id="titolo" placeholder="Titolo" required>
                    <input type="number" name="volume" id="volume" placeholder="Volume" required>
                    <select name="casaEditrice" id="casaEditrice" placeholder="Casa Editrice" required>
                        <option value="Planet Manga">Planet Manga</option>
                        <option value="JPOP">J POP</option>
                        <option value="Star Comics">Star Comics</option>
                    </select>
                    <input type="number" name="prezzo" id="prezzo" placeholder="Prezzo" step="0.01" required>
                    <input type="date" name="dataAcquisto" id="dataAcquisto" placeholder="Data Acquisto" required>
                    <input type="file" name="foto" id="foto" placeholder="Inserisci Foto" accept="image/*" onchange="loadFile(event)" required>
                    <img id="output" width="400" height="600"/>
                    <input type="submit" name="submit" value="Inserisci">
                </form> 
            </div> 
        </div> 
        <!--Casa editrice sbagliato-->
        <div class="modal fade" id="casaEditriceSbagliata" tabindex="-1" aria-labelledby="casaEditriceSbagliataLabel" aria-hidden="true" style="color:black;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="casaEditriceSbagliata">Attenzione</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sembra che la casa editrice inserita sia sbagliata!
                    </div>
                    <div class="modal-footer">                               
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>  
        <!--Volume duplicato-->
        <div class="modal fade" id="duplicato" tabindex="-1" aria-labelledby="duplicatoLabel" aria-hidden="true" style="color:black;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="duplicato">Attenzione</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sembra che il volume sia già stato inserito nella biblioteca!
                    </div>
                    <div class="modal-footer">                               
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div> 

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script> 
        <script>
            var loadFile = function(event) {
                var image = document.getElementById('output');
                image.src = URL.createObjectURL(event.target.files[0]);
            };                      
        </script>
        </body>
    <?php
        if($editoreSbagliato)
        {
            echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#casaEditriceSbagliata").modal("show");
			});
            </script>';            
        }
        if($duplicato)
        {
            echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#duplicato").modal("show");
			});
            </script>';            
        }        
    ?>
</html>