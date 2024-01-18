<h1>Status-Änderungen der Medien verstehen:</h1>
Die folgende Tabelle führt die möglichen Stati für die Exemplare von Medien auf.<br><br>
<table class="primary">
  <tr><th>Status</th><th>Beschreibung</th></tr>
  <tr><td class="primary" valign="top">verfügbar</td><td class="primary">Das Medium steht im Regal und kann ausgeliehen werden.</td></tr>
  <tr><td class="primary" valign="top">ausgeliehen</td><td class="primary">Das Medium wurde von einem Benutzer ausgeliehen.</td></tr>
  <tr><td class="primary" valign="top">vorbestellt</td><td class="primary">Das Medium wird für einen Benutzer zurückgehalten, welcher dieses Medium vorbestellt hat.</td></tr>
  <tr><td class="primary" valign="top">in Eingangsablage</td><td class="primary">Das Medium steht in der Eingangsablage und wartet darauf ins Regal einsortiert zu werden (kann beim Bibliothekar direkt abgeholt werden).</td></tr>
  <tr><td class="primary" valign="top">beschädigt</td><td class="primary">Das Medium ist beschädigt und wird gerade repariert.</td></tr>
  <tr><td class="primary" valign="top">in Präsentation</td><td class="primary">Das Medium kann nicht ausgeliehen werden, da es zur Zeit präsentiert wird.</td></tr>
  <tr><td class="primary" valign="top">verloren</td><td class="primary">Das Medium kann nicht ausgeliehen werden, da es nicht mehr gefunden werden kann.</td></tr>
  <tr><td class="primary" valign="top">Leihgabe</td><td class="primary">Das Medium ist derzeit als Leihgabe weggegeben.</td></tr>
  <tr><td class="primary" valign="top">bestellt</td><td class="primary">Das Medium wurde schon bestellt, ist aber derzeit noch nicht da.</td></tr>
</table>
<br>
Die Statusänderungen werden auf den folgenden Seiten mit den folgenden Regeln erlaubt.<br><br>
<table class="primary">
  <tr><th>Seite</th><th>Alter Status</th><th>Neuer Status</th><th>Regeln</th></tr>
  <tr>
    <td class="primary" valign="top" rowspan="3">Benutzerinfo</td>
    <td class="primary" valign="top">verfügbar</td>
    <td class="primary" valign="top">ausgeliehen</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">andere<sup>*</sup></td>
    <td class="primary" valign="top">ausgeliehen</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">vorbestellt</td>
    <td class="primary" valign="top">ausgeliehen</td>
    <td class="primary" valign="top">Nur erlaubt, wenn der Benutzer der Erste in der Vorbestelliste für dieses Exemplar ist, oder wenn die Vorbestelliste leer ist.</td>
  </tr>
  <tr>
    <td class="primary" valign="top" rowspan="5">Medienrückgabe</td>
    <td class="primary" valign="top">ausgeliehen</td>
    <td class="primary" valign="top">in Eingangsablage</td>
    <td class="primary" valign="top">die Kosten für verspätete Abgabe werden berechnet.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">ausgeliehen</td>
    <td class="primary" valign="top">vorbestellt</td>
    <td class="primary" valign="top">die Kosten für verspätete Abgabe werden berechnet und eine Nachricht wird gezeigt, das das Medium vorbestellt ist.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">andere<sup>*</sup></td>
    <td class="primary" valign="top">in Eingangsablage</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">vorbestellt</td>
    <td class="primary" valign="top">in Eingangsablage</td>
    <td class="primary" valign="top">Ist nur erlaubt, wenn die Vorbestelliste leer ist.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">in Eingangsablage</td>
    <td class="primary" valign="top">verfügbar</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top" rowspan="3">Medieninfo</td>
    <td class="primary" valign="top">andere<sup>*</sup></td>
    <td class="primary" valign="top">verfügbar</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">andere<sup>*</sup></td>
    <td class="primary" valign="top">andere<sup>*</sup></td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">verfügbar</td>
    <td class="primary" valign="top">andere<sup>*</sup></td>
    <td class="primary" valign="top"></td>
  </tr>
</table>

<font class="small">* - Bemerkung: andere enthält beschädigt, in Präsentation, verloren, Leihgabe und bestellt Stati.</font>
