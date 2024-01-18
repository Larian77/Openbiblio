<h1>Neues Exemplar und Exemplar bearbeiten</h1>
<br><br>

Hilfe Untersektionen:
<ul>
  <li><a href="#desc">Feldbeschreibungen</a></li>
  <li><a href="#barc">Einen externen Barcode eingeben</a></li>
  <li><a href="#auto">Einen Barcode automatisch generieren</a></li>
  <li><a href="#seri">Seriele Nummern kopieren, die in Barcodes integriert sind</a></li>
</ul>
<br><br>

<a id="desc">
Die folgende Tabelle beschreibt die Felder, die im Dialog Neues Exemplar bzw. Exemplar bearbeiten auftauchen.</a>
<br><br>

<table class="primary">
  <tr><th>Feld</th><th>Beschreibung</th></tr>
  <tr>
    <td class="primary" valign="top">Barcode</td>
    <td class="primary" valign="top">Eindeutiger Code, der ein Exemplar identifiziert,
maximal 20 Zeichen. Dieses Feld ist eine Pflichtangabe, weil es das Exemplar bei der Ausleihe, Rückgabe und Vorbestellung identifiziert.
<br>Siehe auch: 
<a href="../shared/help.php?page=barcodes">Barcodes verstehen</a>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">Beschreibung</td>
    <td class="primary" valign="top">Kurze Beschreibung dieses Exemplars</td>
  </tr>
  <tr>
    <td class="primary" valign="top">Status</td>
    <td class="primary" valign="top"><b>Nur beim Bearbeiten änderbar</b>.
<br>Siehe auch: 
<a href="../shared/help.php?page=status">Status-Änderungen der Medien verstehen</a>
    </td>
  </tr>
</table>
<br><br>

<a id="barc">Einen externen Barcode eingeben</a>:
<ul>
  <li>Entweder den Barcode manuell eingeben oder einen Barcodescanner verwenden, wenn das Exemplar schon einen Barcode hat,</li>
  <li>Übermitteln (Autom. Generierung deaktiviert).</li>
</ul>
<br>

<a id="auto">
Wenn man bei einem neues Exemplar die Funktion <input name="autobarco" type="checkbox" checked> Autom. Generierung</a> 
auswählt, versucht Openbiblio automatisch eine neue Nummer zu erstellen, entsprechend den Reglen der internen Nummerierung
<ul>
  <li>Der erste Teil wird dabei aus der <i>Medien-ID</i> errechnet, die das Medium in
Openbiblio intern hat (mit führenden Nullen). Die Standardlänge ist 5 Zeichen, das kann geändert werden,
indem man den Wert $nzeros in biblio_copy_new.php ändert.</li>
  <li>Der letzte Teil wird aus der <i>Exemplar-ID</i> errechnet.</li>
</ul>
<br><br>

<a id="seri">
Das Kopieren von Seriennummern, die in Barcodes integriert sind</a> erleichtert die Eingabe von Exemplaren aus einer einfachen Kartei, wenn keine eindeutigen Nummern vergeben wurden, sondern nur Seriennummern für mehrere Exemplare eines Titels. 
<br>
Auf der Barcode-Suche-Hilfe Seite gibt es außerdem Informationen wie man 
<a href="../shared/help.php?page=opacLookup#seri">Seriennummern in automatisch generierten Barcodes findet</a>.
<br>
Wenn man Exemplare hinzufügen möchte, die nur eine Seriennummer besitzen geht man folgendermaßen vor:
<ul>
  <li>Autom. Generierung einschalten,</li>
  <li>solange neue Kopien anlegen, bis die letzten Stellen des generierten Code mit der Seriennummer übereinstimmen,</li>
  <li>löschen der permanent nicht verfügbaren Exemplare und Ändern des Status bei den Anderen.</li>
</ul>
<br><br>
