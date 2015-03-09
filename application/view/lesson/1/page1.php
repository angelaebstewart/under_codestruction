<form id="questions" action="#" method="POST">
    <br>Scenario: You need to go to the store to get any items for your party that you don't already have.<br>
    <br>Given: Your list of items to buy includes chips, dip, soda, a fruit tray, cups, and plates.<br>
    You first need to check your kitchen for each item.<br>

    <br>while(more items on list) {
    <br>&nbsp;&nbsp;&nbsp;&nbsp;if (<select id="Q1" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You only want a list of items you don't have.">item is not in kitchen</option>
        <option value="right">item is in kitchen</option>
    </select>                
        )
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;remove item from list
        <br>}

    <button name="submit" type="submit" value="next_task">Next Task</button>
</form>