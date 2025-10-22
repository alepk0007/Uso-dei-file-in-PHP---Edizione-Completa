<?php
$filename = "random-grades 1.csv";

if (!file_exists($filename)) {
    die("<p>Errore: file CSV non trovato.</p>");
}

$handle = fopen($filename, "r");
$headers = fgetcsv($handle, 0, ";");
$data = [];

while (($row = fgetcsv($handle, 0, ";")) !== false) {
    $record = array_combine($headers, $row);
    $data[] = $record;
}
fclose($handle);

function calcola_media($voti) {
    return count($voti) > 0 ? array_sum($voti) / count($voti) : 0;
}

$raggruppamento = $_POST['raggruppamento'] ?? 'studente';

echo '<form method="POST" style="margin-bottom:20px;">
    <label for="raggruppamento">Raggruppa per: </label>
    <select name="raggruppamento" id="raggruppamento">
        <option value="studente" ' . ($raggruppamento == 'studente' ? 'selected' : '') . '>Studente</option>
        <option value="materia" ' . ($raggruppamento == 'materia' ? 'selected' : '') . '>Materia</option>
        <option value="classe" ' . ($raggruppamento == 'classe' ? 'selected' : '') . '>Classe</option>
    </select>
    <button type="submit">Visualizza</button>
</form>';

if ($raggruppamento == 'studente') {
    $studenti = [];

    foreach ($data as $riga) {
        $studente = $riga['Nome'] . " " . $riga['Cognome'];
        $materia = $riga['Materia'];
        $voto = (float)$riga['Voto'];

        $studenti[$studente]['materie'][$materia][] = $voto;
    }

    echo "<h2>Medie per studente</h2>";
    echo "<table border='1' cellpadding='5'><tr><th>Studente</th><th>Media Generale</th><th>Dettaglio materie</th></tr>";

    foreach ($studenti as $studente => $info) {
        $tutti_voti = [];
        foreach ($info['materie'] as $voti) {
            $tutti_voti = array_merge($tutti_voti, $voti);
        }
        $media_generale = calcola_media($tutti_voti);

        echo "<tr><td><b>$studente</b></td><td>" . number_format($media_generale, 2) . "</td><td>";
        foreach ($info['materie'] as $materia => $voti) {
            echo "$materia: <b>" . number_format(calcola_media($voti), 2) . "</b><br>";
        }
        echo "</td></tr>";
    }
    echo "</table>";
}

elseif ($raggruppamento == 'materia') {
    $materie = [];

    foreach ($data as $riga) {
        $materia = $riga['Materia'];
        $voto = (float)$riga['Voto'];
        $materie[$materia][] = $voto;
    }

    echo "<h2>Medie per materia</h2>";
    echo "<table border='1' cellpadding='5'><tr><th>Materia</th><th>Media</th></tr>";

    foreach ($materie as $materia => $voti) {
        echo "<tr><td>$materia</td><td>" . number_format(calcola_media($voti), 2) . "</td></tr>";
    }

    echo "</table>";
}

elseif ($raggruppamento == 'classe') {
    $tabellone = [];
    $materie_trovate = [];

    foreach ($data as $riga) {
        $classe = $riga['Classe'];
        $studente = $riga['Nome'] . " " . $riga['Cognome'];
        $materia = $riga['Materia'];
        $voto = (float)$riga['Voto'];

        $tabellone[$classe][$studente][$materia][] = $voto;
        $materie_trovate[$materia] = true;
    }

    foreach ($tabellone as $classe => $studenti) {
        echo "<h2>Tabellone Classe $classe</h2>";
        echo "<table border='1' cellpadding='5'><tr><th>Studente</th>";

        foreach (array_keys($materie_trovate) as $materia) {
            echo "<th>$materia</th>";
        }
        echo "<th>Media Generale</th></tr>";

        foreach ($studenti as $studente => $materie) {
            $tutti_voti = [];
            echo "<tr><td><b>$studente</b></td>";

            foreach (array_keys($materie_trovate) as $materia) {
                if (isset($materie[$materia])) {
                    $media_materia = calcola_media($materie[$materia]);
                    echo "<td>" . number_format($media_materia, 2) . "</td>";
                    $tutti_voti = array_merge($tutti_voti, $materie[$materia]);
                } else {
                    echo "<td>-</td>";
                }
            }

            echo "<td><b>" . number_format(calcola_media($tutti_voti), 2) . "</b></td></tr>";
        }

        echo "</table><br>";
    }
}
?>
