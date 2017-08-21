<?php
/**
 * @title            QR Code Example
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

require 'QRCode.class.php'; // Include the QRCode class

try
{
 
    $oQRC = new QRCode; // Create vCard Object
    $oQRC->fullName($_REQUEST['storeid']) // Add Full Name  
        ->finish(); // End vCard 
        $oQRC->display(); // Display

}
catch (Exception $oExcept)
{
    echo '<p><b>Exception launched!</b><br /><br />' .
    'Message: ' . $oExcept->getMessage() . '<br />' .
    'File: ' . $oExcept->getFile() . '<br />' .
    'Line: ' . $oExcept->getLine() . '<br />' .
    'Trace: <p/><pre>' . $oExcept->getTraceAsString() . '</pre>';
}
?>

<button onclick="myFunction()">Print this page</button>

<script>
function myFunction() {
    window.print();
}
</script>
