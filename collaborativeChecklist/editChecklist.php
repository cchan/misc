<?php
$_POST["CID"];//checklist ID
$_POST["EID"];//edit ID
$_POST["edit"];//command to edit with
/*Possible commands:
[reorder items?]
n|(IID)|(name) => renames IID to name
a => adds item to end
d|(IID) => deletes item with id IID
ia|(IID)|a|(pos)|(string of chars) => adds string to IID at pos
id|(IID)|d|(posStart)|(length) => deletes string from IID starting at posStart and going for length
*/

/*
The job of the server is to OperationalTransform commands and send them back to clients,
as well as update its own copy of the checklist (as items[] and checks[]) to make it easier on the client first loading it.
*/

?>