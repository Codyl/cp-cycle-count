function changeDisplayedPickCount(item){
    var itemName = item['name'];
    var oldCount = document.getElementById("pickCount_"+itemName).innerText;
    var elem = Number(document.getElementById('pickBin_'+itemName));
    var newCount = elem.value;
    
       //get new pick bin location php update display here
        if (newCount != 0) {
            changeDisplayQty(item);
            //update pick bin by calling php
            if(Number(oldCount) === 0) {
                var newBin = prompt("Please enter the pick bin location of this amount");
                if(newBin === "" || newBin == null) {
                    document.getElementById('pickBin_'+itemName).value='';
                }
                else{
                    //addItemToBin(itemName,newBin,item[warehouse_id],Number(document.getElementById('pickBin_'+itemName).value));
                }
            }
            
        }
        
}
function changeDisplayQty(item) {
    var itemName = item['name'];
    var counttd = document.getElementById("count_"+itemName);
    var writeQtyIO = document.getElementById("writeIO_"+itemName);
    var qoh = document.getElementById("qoh_"+itemName).innerText;
    var totalCost = document.getElementById("totalCost_"+itemName);
    //var itemName = item['item_name'];
    var cost = item['cost'];

    var countQty = 0;
    for(var i = 0;i<document.getElementsByClassName('pltcount_'+itemName).length;i++) {
        if(document.getElementsByClassName('pltCount_'+itemName)[i].value != ''){
            countQty += Number(document.getElementsByClassName('pltCount_'+itemName)[i].value) * Number(item['case_plt']) * Number(item['case_qty']);
        }
    }
    for(var i = 0;i<document.getElementsByClassName('casecount_'+itemName).length;i++) {
        if(document.getElementsByClassName('caseCount_'+itemName)[i].value != ''){
            countQty += Number(document.getElementsByClassName('caseCount_'+itemName)[i].value) * Number(item['case_qty']);
        }
        
    }
    countQty += Number(document.getElementById('pickBin_'+itemName).value);
    writeQtyIO.innerText = countQty - Number(qoh);
    var temp = writeQtyIO.innerText * cost;
    totalCost.innerText = temp.toFixed(2);
    counttd.innerText = Number(countQty);
    changeCountFont(writeQtyIO, totalCost);
}
function changeDisplayedPalletCount(item){
    var elem = Number(document.getElementById('pltBin_'+item['name']));
    var newCount = elem.value;
    if(newCount == 0)
    {
        //remove item from bin in database
        if(confirm("Remove this item from bulk row: ?")){
            console.log("removing item");//removeItemFromBin()
        }
        
    }
    else
    {
        changeDisplayQty(item);
        //addItemToBin()
    }
}


function changeDisplayedCaseCount(item){
    var elem = Number(document.getElementById('caseBin_'+item['name']));
    var newCount = elem.value;
    if(Number(newCount) === 0)
    {
        //remove item from bin in database
        if(confirm("Remove this item from bin: ?"))
            console.log("removing item");
    }
    else {
        changeDisplayQty(item);
        //addItemToBin()
    }
}
function changeCountFont(writeQtyIO, totalCost){
    if(Number(writeQtyIO.innerText) > 0) {
        writeQtyIO.innerHTML = writeQtyIO.innerText.fontcolor("green");
        totalCost.innerHTML = totalCost.innerText.fontcolor("green");
    }
    else if(Number(writeQtyIO.innerText) < 0) {
        writeQtyIO.innerHTML = writeQtyIO.innerText.fontcolor("red");
        totalCost.innerHTML = totalCost.innerText.fontcolor("red");
    }
}
function showCountHistory(){
    //Show a table with counts: count date, start_qty, end_qty
}
//Enables the use if these input when warehouse is selected by user.
function showRCOpt(){
    document.getElementById("recordCount").disabled = false;
    document.getElementById("viewCount").disabled = false;
}
function removetr(elem){
    if(confirm("Are you sure you want to update this count?")){
        var animate = setInterval(shrink(),5);
        
        //update count infr using php

    }
}
function shrink(elem){
    //console.log("height",elem.offsetHeight);
    if(elem.offsetHeight > 0){
        //console.log("try")
        elem.offsetHeight -=5;
    }
    else{
        elem.parentElement.removeChild(elem);
    }
    
}
function sortByTh(th){
    // switch(th){
    //     case "item":
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
    //         break;
    //     case "qoh"://case 1: cannot sort by comments, not a valid sort
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY qoh DESC");
    //     case "qty avail":
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY qty_avail DESC");
    //         break;
    //     case "case":
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY case_qty DESC");
    //         break;
    //     case "case lyr":
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY case_lyr DESC");
    //         break;
    //     case "pick bin":
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY pick DESC");
    //         break;
    //     case 0:
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY whbin DESC");
    //         break;
    //     case 0:
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY count DESC");
    //         break;
    //     case 0:
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY writein DESC");
    //         break;
    //     case 0:
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY cost DESC");
    //         break;
    //     case 0:
    //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY last_counted DESC");
    //         break;
    //     default:
    //         echo "Unexpected error on attempted sorting method.";
    }
    //get whse from database
    function setWarehouse(warehouse) {
        document.getElementById("warehouse").selectedIndex = warehouse;
    }
    function addItemToOrder() {
        var firstDivContent = document.getElementById('itemDiv1');
        var secondDivContent = document.getElementById('orderForm');
        secondDivContent.innerHTML += firstDivContent.innerHTML;
    }
    function addNewCount1(qoh,qtyCounted, writeQtyIO,item){
        jQuery.ajax({
            type: "POST",
            url: 'model.php',
            // dataType: 'json',
            data: {functionname: 'addNewCount', arguments: [qoh,qtyCounted, writeQtyIO,item]}
        });
    }
    