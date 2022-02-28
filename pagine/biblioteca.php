<!DOCTYPE html>
<html>
    <header>
        <title>Biblioteca - Lista</title>
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
                <form class="d-flex">
                    <input class="form-control me-2" id="myInput" type="text" onkeyup="myFunction()" placeholder="Cerca per Titolo" aria-label="Search">
                </form>                
                </div>
            </div>
        </nav>
        <div class="center">
            <table id="myTable" class="mt-3 mb-3">
                <tr>
                    <th onclick="sortTable(0)">Titolo</th>
                    <th onclick="sortTableNumber(1)">Volume</th>
                    <th onclick="sortTableNumber(2)">Prezzo (€)</th>
                    <th onclick="sortTable(3)">Casa Editrice</th>
                    <th onclick="sortTable(4)">Data Acquisto</th>
                </tr>
                <?php
                    $percorsoFile = "../libri/biblioteca.xml";
                        if(file_exists($percorsoFile))
                        {
                            $fileXml = simplexml_load_file($percorsoFile); 
                            foreach($fileXml -> children() as $serie)
                            {
                                foreach($serie -> children() as $volumi)
                                {
                                    echo '
                                        <tr>
                                            <td>'.$serie['titolo'].'</td>
                                            <td>'.$volumi['numero'].'</td>
                                            <td>'.$volumi['prezzo'].'</td>
                                            <td>'.$serie['casaEditrice'].'</td>
                                            <td>'.$volumi['dataAcquisto'].'</td>
                                        </tr>
                                    ';
                                }
                            }   
                        }
                ?>  
            </table>
        </div>
        <script>
            function sortTable(n)
            {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("myTable");
                switching = true;
                dir = "asc";
                while (switching)
                {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++)
                    {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];
                        if (dir == "asc") 
                        {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) 
                            {
                            shouldSwitch = true;
                            break;
                            }
                        } 
                        else if (dir == "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) 
                            {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    if (shouldSwitch) 
                    {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount ++;
                    } 
                    else 
                    {
                        if (switchcount == 0 && dir == "asc") 
                        {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }  
            }
            function sortTableNumber(n)
            {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("myTable");
                switching = true;
                dir = "asc";
                while (switching)
                {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++)
                    {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];
                        if (dir == "asc") 
                        {
                            if (Number(x.innerHTML) > Number(y.innerHTML)) 
                            {
                            shouldSwitch = true;
                            break;
                            }
                        } 
                        else if (dir == "desc") {
                            if (Number(x.innerHTML) < Number(y.innerHTML)) 
                            {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    if (shouldSwitch) 
                    {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount ++;
                    } 
                    else 
                    {
                        if (switchcount == 0 && dir == "asc") 
                        {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }  
            }                         
        </script>
        <link rel="stylesheet" href="../css/mioStile.css">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/mioJs.js"></script>
    </body> 
</html>