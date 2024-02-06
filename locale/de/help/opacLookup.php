<h1>Barcode-Suche:</h1>
<br>
<br>
Der Suchen-Link bei der Ausleihe, Rückgabe und Reservierung öffnet ein
zweites Popup-Fenster, welches mit dem Onlinekatalog(OPAC) fast
identisch ist. Im Ergebnisfenster einer Suche hat jedes Exemplar
zusätzliche Links (Ausleihe/Rückgabe/Reservierung). Wenn man diesen Link
auswählt schließt sich das Fenster und gibt den Barcode zum Hauptfenster
zurück, wo dieser übermittelt werden kann.
<br>
<br>

Hilfe Untersektionen:
<ul>
	<li><a href="#exam">Beispiel: Auswahl eines Barcode aus dem Suchfenster</a></li>
	<li><a href="#seri">Erkennen von Seriennummern in automatisch
			generierten Barcodes</a></li>
</ul>
<br>
<br>

<a id="exam"> Das folgende Beispiel zeigt den link um einen Barcode
	auszuwählen.</a>
Wenn Ihr Browser die Quickinfo unterstützt, dann zeigt Infos an, wenn
Sie mit der Maus über die links fahren.
<br>
<br>

<!--**************************************************************************
    *  Printing result table EXAMPLE ALMOST COMPLETELY TRANSLATED BY $loc->getText 
    ************************************************************************** -->
<table class="primary">
	<tbody>
		<tr>
			<th colspan="3" align="left" style="white-space: nowrap;"
				valign="top">
      <?php echo $loc->getText("biblioSearchResults"); ?>:
    </th>
		</tr>

		<tr>

			<td class="primary" rowspan="2" align="center"
				style="white-space: nowrap;" valign="top">1.<br> <a href="#exam"
				title="<?php echo $loc->getText("biblioSearchDetail"); ?>"> <img
					src="../images/book.gif" alt="book" align="bottom" border="0"
					height="20" width="20"></a>
			</td>
			<td class="primary" colspan="2" valign="top">
				<table style="width: 100%;" class="primary">
					<tbody>
						<tr>

							<td class="noborder" valign="top" width="1%"><b><?php echo $loc->getText("biblioSearchTitle"); ?>:</b></td>
							<td class="noborder" colspan="3"><a href="#exam"
								title="<?php echo $loc->getText("biblioSearchDetail"); ?>">Ribsy</a></td>
						</tr>
						<tr>
							<td class="noborder" valign="top"><b><?php echo $loc->getText("biblioSearchAuthor"); ?>:</b></td>
							<td class="noborder" colspan="3">Cleary,Beverly</td>
						</tr>
						<tr>
							<td class="noborder" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchMaterial"); ?>:</b></font></td>
							<td class="noborder" colspan="3"><font class="small">Buch</font></td>
						</tr>
						<tr>
							<td class="noborder" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchCollection"); ?>:</b></font></td>
							<td class="noborder" colspan="3"><font class="small">Jugendliteratur</font></td>

						</tr>
						<tr>
							<td class="noborder" style="white-space: nowrap;" valign="top"><font
								class="small"><b><?php echo $loc->getText("biblioSearchCall"); ?>:</b></font></td>
							<td class="noborder" colspan="3"><font class="small">JF Cle </font></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyBCode"); ?></b>:
					000051 <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Chk"); ?>"><?php echo $loc->getText("biblioSearchOutIn"); ?></a>
					| <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Hold"); ?>"><?php echo $loc->getText("biblioSearchHold"); ?></a>
			</font></td>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyStatus"); ?></b>:
					verfügbar</font></td>
		</tr>


		<tr>
			<td class="primary" rowspan="2" align="center"
				style="white-space: nowrap;" valign="top">2.<br> <a href="#exam"
				title="<?php echo $loc->getText("biblioSearchDetail"); ?>"> <img
					src="../images/book.gif" alt="book" align="bottom" border="0"
					height="20" width="20"></a>
			</td>
			<td class="primary" colspan="2" valign="top">
				<table style="width: 100%;" class="primary">

					<tbody>
						<tr>
							<td class="noborder" valign="top" width="1%"><b><?php echo $loc->getText("biblioSearchTitle"); ?>:</b></td>
							<td class="noborder" colspan="3"><a href="#exam"
								title="<?php echo $loc->getText("biblioSearchDetail"); ?>">Henry
									Huggins</a></td>
						</tr>
						<tr>
							<td class="noborder" valign="top"><b><?php echo $loc->getText("biblioSearchAuthor"); ?>:</b></td>
							<td class="noborder" colspan="3">Cleary,Beverly</td>

						</tr>
						<tr>
							<td class="noborder" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchMaterial"); ?>:</b></font></td>
							<td class="noborder" colspan="3"><font class="small">Buch</font></td>
						</tr>
						<tr>
							<td class="noborder" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchCollection"); ?>:</b></font></td>

							<td class="noborder" colspan="3"><font class="small">Jugendliteratur</font></td>
						</tr>
						<tr>
							<td class="noborder" style="white-space: nowrap;" valign="top"><font
								class="small"><b><?php echo $loc->getText("biblioSearchCall"); ?>:</b></font></td>
							<td class="noborder" colspan="3"><font class="small">JF Cle </font></td>
						</tr>
					</tbody>
				</table>

			</td>
		</tr>
		<tr>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyBCode"); ?></b>:
					000061 <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Chk"); ?>"><?php echo $loc->getText("biblioSearchOutIn"); ?></a>
					| <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Hold"); ?>"><?php echo $loc->getText("biblioSearchHold"); ?></a>
			</font></td>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyStatus"); ?></b>:
					verfügbar</font></td>

		</tr>
		<tr>
			<td class="primary" align="center" style="white-space: nowrap;"
				valign="top"><font class="small"> 3. </font></td>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyBCode"); ?></b>:
					000062 <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Chk"); ?>"><?php echo $loc->getText("biblioSearchOutIn"); ?></a>
					| <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Hold"); ?>"><?php echo $loc->getText("biblioSearchHold"); ?></a>

			</font></td>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyStatus"); ?></b>:
					verfügbar</font></td>
		</tr>
		<tr>
			<td class="primary" align="center" style="white-space: nowrap;"
				valign="top"><font class="small"> 4. </font></td>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyBCode"); ?></b>:
					000063 <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Chk"); ?>"><?php echo $loc->getText("biblioSearchOutIn"); ?></a>
					| <a href="#exam"
					title="<?php echo $loc->getText("biblioSearchBCode2Hold"); ?>"><?php echo $loc->getText("biblioSearchHold"); ?></a>

			</font></td>
			<td class="primary" style="white-space: nowrap;"><font class="small"><b><?php echo $loc->getText("biblioSearchCopyStatus"); ?></b>:
					verfügbar</font></td>
		</tr>
	</tbody>
</table>
<br>

<a id="seri"> Im Barcode-Suche-Beispiel oben, unterscheidet sich der
	Barcode nur in den letzten Ziffern.</a>
Dieses ist, weil diese Barcodes mit der Funktion
<a href="../shared/help.php?page=biblioCopyEdit#seri">Kopiere Serielle
	Nummern integriert in Barcodes</a>
angelegt wurden, als die Exemplare erstellt wurden.
<br>
Dies und noch anderes wird erklärt in der Hilfe zu
<a href="../shared/help.php?page=biblioCopyEdit">Neues Exemplar und
	Exemplar bearbeiten</a>
.
<br>
<br>
Beachten Sie, dass die Nummerierung in der linken Spalte, unabhängig zu
Kopiere Serielle Nummern integriert in Barcodes ist.
