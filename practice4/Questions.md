# Fragen
### 1) Wo erfolgt der eigentliche Aufruf zur Erstellung einer HTML-Seite?
Der eigentliche Aufruf zur Erstellung einer HTML-Seite erfolgt in der `generateView()` Funktion der jeweiligen PageTemplate-Klasse.

### 2) Was tun die Methoden getViewData(), generateView() und processReceivedData()?
- `getViewData()`: Holt sich die Daten aus der Datenbank zur weiteren Verarbeitung. Die Daten werden in die jeweilige Datenstruktur eingepflegt.
- `generateView()`: Hier wird die HTML-Seite ausgegeben, indem auf die Variablen in der Datenstruktur zugegriffen wird.
- `porcessReceiveData()`: Hier werden POST- und GET-Daten augewertet und in die Datenbank geschrieben.

### 3) Wo wird der HTML-Rahmen erzeugt? Wo wird er ausgegeben?
In der Datei `Page.php` wird der HTML-Rahmen erzeugt, dort wird der Header in der `generatePageHeader()` Funktion und der Footer in der `generatePageFooter()` Funktion ausgegeben. 