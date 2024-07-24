<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Range Slider avec Images et Dates</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <h2>L'histoire de Sud Ouest</h2>
    <?php
    // Chemin vers le fichier CSV
    $csvFile = 'datas/datas.csv';
    $i = 1;
    $dataArray = [];

    // Ouverture du fichier en mode lecture
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        // Lire et ignorer la première ligne (en-tête)
        fgetcsv($handle, 1000, ',');

        // Lecture de chaque ligne du fichier CSV et stockage dans un tableau
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $dataArray[] = $data;
        }

        // Fermeture du fichier
        fclose($handle);

        // Génération du premier bloc HTML
        echo '
        <div id="imageContainer">
            <button class="arrow left" id="prev"><b>&#9664;</b></button>
    ';

        foreach ($dataArray as $index => $data) {
            echo '<img src="images/' . $data[2] . '" id="image' . ($index + 1) . '" alt="' . $data[0] . '">';
        }

        echo '<button class="arrow right" id="next"><b>&#9654;</b></button>
        </div>';

        // Génération de la barre de défilement
        echo '<div class="rangeBarre">
            <input type="range" id="rangeSlider" min="1" max="' . count($dataArray) . '" value="1">
        </div>';

        //* Génération des dates
        echo '<div id="dates">';
        foreach ($dataArray as $index => $data) {
            echo '<span id="date' . ($index + 1) . '" data-index="' . ($index + 1) . '">' . $data[0] . '</span>';
        }
        echo '</div>';
        //* FIN Génération des dates

        //* Génération des blocs texte
        echo '<div id="textContainer">';
        foreach ($dataArray as $index => $data) {
            echo '<p id="text' . ($index + 1) . '">' . $data[1];
        }
        echo '</p></div>';
        //* FIN Génération des blocs texte

    } else {
        echo 'Erreur: impossible d\'ouvrir le fichier CSV.';
    }
    ?>

    <!-- <div id="imageContainer">
        <button class="arrow left" id="prev"><b>&#9664;</b></button>
        <img src="images/1944.jpg" id="image1" class="active" alt="1944">
        <img src="images/1984.jpg" id="image2" alt="1984">
        <img src="images/2024.jpg" id="image3" alt="2024">
        <button class="arrow right" id="next"><b>&#9654;</b></button>
    </div> -->

    <!-- <div class="rangeBarre">
        <input type="range" id="rangeSlider" min="1" max="3" value="1">
    </div>

    <div id="dates">
        <span id="date1" data-index="1">1944</span>
        <span id="date2" data-index="2">1984</span>
        <span id="date3" data-index="3">2024</span>
    </div> -->

    <!-- <div id="textContainer">
        <p id="text1" class="active"><b>Texte de 200 signes pour l'année 1944.</b></br>Lorem ipsum dolor sit amet,
            consectetur adipiscing elit. Proin convallis feugiat ligula, nec interdum erat efficitur non. Curabitur ut
            turpis at metus fermentum.</p>
        <p id="text2"><b>Texte de 200 signes pour l'année 1984.</b></br>Lorem ipsum dolor sit amet, consectetur
            adipiscing elit. Proin convallis feugiat ligula, nec interdum erat efficitur non. Curabitur ut turpis at
            metus fermentum.</p>
        <p id="text3"><b>Texte de 200 signes pour l'année 2024.</b></br>Lorem ipsum dolor sit amet, consectetur
            adipiscing elit. Proin convallis feugiat ligula, nec interdum erat efficitur non. Curabitur ut turpis at
            metus fermentum.</p>
    </div> -->
    <script src="js/slider.js"></script>
</body>

</html>