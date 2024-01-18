<h1>Understanding Bibliography Status Changes:</h1>
The following table lists the possible status states for a bibliography copy.<br><br>
<table class="primary">
  <tr><th>Status</th><th>Description</th></tr>
  <tr><td class="primary" valign="top">checked in</td><td class="primary">Bibliography is shelved and available for checkout.</td></tr>
  <tr><td class="primary" valign="top">checked out</td><td class="primary">Bibliography is checked out by a library member.</td></tr>
  <tr><td class="primary" valign="top">on hold</td><td class="primary">Bibliography is being held for pickup by a member who has placed a hold on the bibliography.</td></tr>
  <tr><td class="primary" valign="top">shelving cart</td><td class="primary">Bibliography is on the shelving cart waiting to be shelved.</td></tr>
  <tr><td class="primary" valign="top">damaged/mending</td><td class="primary">Bibliography is currently being repaired due to damages.</td></tr>
  <tr><td class="primary" valign="top">display area</td><td class="primary">Bibliography is not available for checkout because it is in a display case.</td></tr>
  <tr><td class="primary" valign="top">lost</td><td class="primary">Bibliography is not availbale for checkout because it can not be found.</td></tr>
  <tr><td class="primary" valign="top">on loan</td><td class="primary">Bibliography is on loan.</td></tr>
  <tr><td class="primary" valign="top">on order</td><td class="primary">Bibliography is on order and has not arrived yet.</td></tr>
</table>
<br>
Bibliography status changes are allowed on the following pages with the following rules.<br><br>
<table class="primary">
  <tr><th>Page</th><th>Old Status</th><th>New Status</th><th>Rules</th></tr>
  <tr>
    <td class="primary" valign="top" rowspan="3">member info</td>
    <td class="primary" valign="top">checked in</td>
    <td class="primary" valign="top">checked out</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">other<sup>*</sup></td>
    <td class="primary" valign="top">checked out</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">on hold</td>
    <td class="primary" valign="top">checked out</td>
    <td class="primary" valign="top">Only allow if member is first in hold queue for the given copy or if hold queue is empty.</td>
  </tr>
  <tr>
    <td class="primary" valign="top" rowspan="5">check in</td>
    <td class="primary" valign="top">checked out</td>
    <td class="primary" valign="top">shelving cart</td>
    <td class="primary" valign="top">Will calculate late fees.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">checked out</td>
    <td class="primary" valign="top">on hold</td>
    <td class="primary" valign="top">Will calculate late fees and show message to place book in hold storage.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">other<sup>*</sup></td>
    <td class="primary" valign="top">shelving cart</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">on hold</td>
    <td class="primary" valign="top">shelving cart</td>
    <td class="primary" valign="top">Will only allow if hold queue for given copy is empty.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">shelving cart</td>
    <td class="primary" valign="top">checked in</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top" rowspan="3">biblio info</td>
    <td class="primary" valign="top">other<sup>*</sup></td>
    <td class="primary" valign="top">checked in</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">other<sup>*</sup></td>
    <td class="primary" valign="top">other<sup>*</sup></td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">checked in</td>
    <td class="primary" valign="top">other<sup>*</sup></td>
    <td class="primary" valign="top"></td>
  </tr>
</table>

<font class="small">* - note: other includes damaged/mend, display, lost, on loan and on order status states.</font>
