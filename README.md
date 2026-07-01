### 📊 Registro Voti - Edizione Completa (PHP)

Un'applicazione web avanzata in PHP per la lettura, il parsing e l'aggregazione dinamica di valutazioni scolastiche a partire da un dataset CSV. Questa versione introduce un motore di elaborazione che raggruppa le statistiche offrendo tre prospettive di visualizzazione distinte: Studente, Materia e Classe.

#### 🚀 Funzionalità Principali

* **Parsing Strutturato Avanzato:** Lo script utilizza `fopen` e `fgetcsv` (con delimitatore `;`) per leggere il file riga per riga, mappando i dati alle rispettive intestazioni tramite `array_combine()`. Questo converte le righe testuali in array associativi, rendendo l'estrazione delle informazioni molto più robusta e leggibile.


* **Interfaccia Interattiva (Stateful):** Un modulo HTML (inviato tramite `POST`) permette all'utente di selezionare la modalità di raggruppamento tramite un menu a tendina (`<select>`). Lo script "ricorda" l'ultima selezione effettuata mantenendo attivo l'attributo `selected` sull'opzione scelta.


* **Motore di Raggruppamento a Tre Vie:**
* **Per Studente:** Associa ogni voto allo specifico alunno, calcolando e formattando a due cifre decimali sia la media generale globale, sia il dettaglio scorporato per singola materia.


* **Per Materia:** Estrapola dal file l'andamento globale di ogni disciplina, restituendo una tabella con le medie assolute per materia dell'intero istituto.


* **Tabellone per Classe (Stile Pivot):** Genera una matrice complessa per ciascuna classe. Incrocia dinamicamente i nomi degli studenti (sulle righe) con un set dinamico di tutte le materie trovate nel file (sulle colonne), calcolando medie parziali e generali per simulare il tabellone degli scrutini finali.




* **Gestione dei Dati Mancanti:** Durante la costruzione del tabellone di classe, il sistema verifica se l'alunno possiede valutazioni per una specifica colonna (`isset`); in caso contrario, inserisce un trattino (`-`), mantenendo intatta l'impaginazione della tabella e prevenendo errori matematici.



#### 🛠 Tecnologie Utilizzate

* **Backend:** PHP (gestione avanzata di stream file I/O, manipolazione di array multidimensionali, funzioni custom per il calcolo matematico `calcola_media()`).


* **Frontend:** HTML per la renderizzazione nativa di form e tabelle dati complesse.



#### ⚙️ Come testare il progetto

1. Posiziona lo script in un ambiente server locale con supporto PHP (es. XAMPP o MAMP).
2. Assicurati che il file dati sia formattato con il delimitatore punto e virgola (`;`). *(Nota: lo script punta al file `random-grades 1.csv`. Se stai usando il nuovo file `random-grades 1_2.csv`, dovrai aggiornare la variabile `$filename` alla riga 2 del codice sorgente)*.


3. Avvia la pagina dal tuo browser web locale.
4. Utilizza il menu a tendina "Raggruppa per" e clicca su "Visualizza" per processare il dataset e generare le tabelle incrociate in tempo reale.
