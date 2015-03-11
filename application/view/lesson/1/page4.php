<form id="questions" action="#" method="POST">
    <br><div class="gameElement">Given: Now you have to pay for you items and get home.</div>
    <br><div class="gameElement">You're at the cash register now.</div>
    <br><div class="gameElement">You’re on your own for this one. Fill in all the blanks.</div><br>
    <br>
    <div class="gameElement"><select id="Q15" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="This choice only allows the statement below to run once.">if</option>
        <option value="right">while</option></select>
    (<select id="Q16" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You need to get all items out of your cart and paid for.">no items in cart</option>
        <option value="right">more items in cart</option></select>) {</div><br>
        <div class="gameElement">&nbsp;&nbsp;&nbsp;&nbsp;<select id="Q17" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="The items are already in your cart">add item to cart</option>
        <option value="Don't leave before getting your groceries!">drive home</option>
        <option value="right">ring up item</option>
        <option value="The cash register needs to calculate the price of your order first..">pay for items</option>
        <option value="You're at the cash register right now.">put items in car</option>
        <option value="You need this item for your party!">throw away item</option></select></div>
        <br><div class="gameElement">}</div>
        <br><div class="gameElement"><select id="Q18" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You're at the cash register right now.">add item to cart</option>
        <option value="You need to buy your groceries.">drive home</option>
        <option value="You already did this for all the items.">ring up item</option>
        <option value="right">pay for items</option>
        <option value="You're at the cash register right now.">put items in car</option>
        <option value="You need this item for your party!">throw away item</option></select></div><br>
    <div class="gameElement"><select id="Q19" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="This choice only allows the statement below to run once.">if</option>
        <option value="right">while</option></select>
    (<select id="Q20" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You need to get all items into your car.">no items to put in car</option>
        <option value="right">more items to put in car</option></select>)</div><br>
        <div class="gameElement">&nbsp;&nbsp;&nbsp;&nbsp;<select id="Q21" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="The item is currently in the cart. It needs to be put elsewhere.">add item to cart</option>
        <option value="You need to get the items into your car.">drive home</option>
        <option value="You already did this.">ring up items</option>
        <option value="You already did this.">pay for items</option>
        <option value="right">put item in car</option>
        <option value="You need this item for your party!">throw away items</option></select></div>
    <br><div class="gameElement"><select id="Q22" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="The items are in your car. You don't want them back in the cart.">add item to cart</option>
        <option value="right">drive home</option>
        <option value="You already did this.">ring up items</option>
        <option value="You already did this.">pay for items</option>
        <option value="You already did this.">put item in car</option>
        <option value="You need this item for your party!">throw away items</option></select></div>
    <br><br>
    <div class="gameElement"><button name="submit" type="submit" value="next_task">Done!</button></div>
</form>