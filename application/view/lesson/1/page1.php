<form id="questions" action="#" method="POST">
    <div  class="gameElement">Scenario: You need to go to the store to get any items for your party that you don't already have.</div>
    <br>
    <br><div class="gameElement">Given: Your list of items to buy includes chips, dip, soda, a fruit tray, cups, and plates.</div>
    <br><div class="gameElement">You first need to check your kitchen for each item.</div><br>
    <br>
    <br><div class="gameElement">while(more items on list) {</div>
    <br><div class="gameElement">&nbsp;&nbsp;&nbsp;&nbsp;if (<select id="Q1" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You only want a list of items you don't have.">item is not in kitchen</option>
        <option value="right">item is in kitchen</option>
    </select>                
        )</div>
        <br><div class="gameElement">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;remove item from list</div>
        <br><div class="gameElement">}</div>
    <br>
    <br><div class="gameElement"><button name="submit" type="submit" value="next_task">Next Task</button></div>
</form>