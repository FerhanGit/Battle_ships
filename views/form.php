<form name="inputForm" id="inputForm" action="index.php" method="POST">
    <br />
    Enter coordinates (row, col), e.g. A5 
    <input type="input" size="5" name="shootValue" id="shootValue" autocomplete="off" autofocus onKeyUp="this.value = this.value.toUpperCase();">
    <input name="shootBtn" id="shootBtn" type="submit">
    
</form>
<br />
<input type='button' value='Show' id='show' name='show'><label for="show"> (Click if you want to view/hide hint with ships coordinates) </label>