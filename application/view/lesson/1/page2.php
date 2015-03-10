<form id="questions" action="#" method="POST">
    <br>Given: You know what items you need to buy from the store. The next step is 
    getting to the store.<br> The store is an unknown distance away, and you must 
        drive there and back.<br>
        <br>if (<select id="Q2" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">* (multiply)</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">2</option>
        <option value="right">amount of gas</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">distance to store</option>
        </select>&gt;distance to store
        <select id="Q4" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="right">* (multiply)</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">2</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">amount of gas</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">distance to store</option>
    </select>
        <select id="Q5" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">* (multiply)</option>
        <option value="right">2</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">amount of gas</option>
        <option value="Place these choices so that you have enough gas to go to and from the store.">distance to store</option>
    </select>) {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;drive to store<br>
        }<br>

        <br> else {
        <br>&nbsp;&nbsp;&nbsp;&nbsp;drive to gas station<br>
        &nbsp;&nbsp;&nbsp;&nbsp;<select id="Q6" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You're here because you didn't have enough gas.">buy a candy bar</option>
        <option value="You're here because you didn't have enough gas.">drive back home</option>
        <option value="You're here because you didn't have enough gas.">drive to store</option>
        <option value="right">pump gas</option>
    </select><br>
        &nbsp;&nbsp;&nbsp;&nbsp;<select id="Q7" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="Remember the intended destination.">buy a candy bar</option>
        <option value="Remember the intended destination.">drive back home</option>
        <option value="right">drive to store</option>
        <option value="Remember the intended destination.">pump gas</option>
    </select><br><br>
        }<br>

    <button name="submit" type="submit" value="next_task">Next Task</button>


</form>