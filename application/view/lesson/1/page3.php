<form id="questions" action="#" method="POST">
    <br>Given: You are now in the store and you have your list of items. 
        However, you discover you only have $20!<br> You must buy everything, 
        tax included, for under $20. Tax is 10%.<br>
    <br><select id="Q8" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="Ascending importance means you'll get the least important items first.">sort by ascending importance</option>
        <option value="right">sort by descending importance</option>
        <option value="Price doesn't matter. Some items are more important than others.">sort by price</option></select><br>
        while(<select id="Q9" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="There are items on your list so this would mean the loop doesn't start.">no items on list</option>
        <option value="right">more items on list</option></select>) { <br>
        &nbsp;&nbsp;&nbsp;&nbsp; itemCost = <select id="Q10" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="This loop deals with one item at a time.">cost of all items</option>
        <option value="right">cost of current item</option></select><br>
        &nbsp;&nbsp;&nbsp;&nbsp; itemCostPlusTax = itemCost <select id="Q11" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="right">+ (plus)</option>
        <option value="An item with tax is more than the sticker price.">- (minus)</option>
        <option value="Multiplying the tax makes for an expensive grocery!">* (multiply)</option>
        <option value="An item with tax is more than the sticker price.">/ (divide)</option></select>
        itemCost <select id="Q12" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You're calculating the percentage of an item, not adding to it.">+ (plus)</option>
        <option value="Tax makes the price higher.">- (minus)</option>
        <option value="right">* (multiply)</option>
        <option value="Tax makes the price higher.">/ (divide)</option></select> 
        taxPercentage<br>
        &nbsp;&nbsp;&nbsp;&nbsp; if (money you have left <select id="Q13" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="You need at least as much money as the cost to buy an item.">&gt;</option>
        <option value="right">&gt;=</option>
        <option value="You need at least as much money as the cost to buy an item.">&lt;</option>
        <option value="You need at least as much money as the cost to buy an item.">&lt;=</option>
        <option value="You need at least as much money as the cost to buy an item.">=</option></select> 
        itemCostPlusTax) {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="Q14" onchange="check(this.value, this.id)">
        <option value="Please make a selection."></option>
        <option value="right">add item to shopping cart</option>
        <option value="This item isn't even in your cart yet and you need it.">remove item from shopping cart</option>
        <option value="That's immoral!">steal item</option></select><br>
        &nbsp;&nbsp;&nbsp;&nbsp;}<br>}

    <button name="submit" type="submit" value="next_task">Next Task</button>
</form>