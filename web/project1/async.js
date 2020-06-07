function changeDisplayedPickCount(itemName, elem, cost, item){
    var countQty,writeQtyIO, totalCost;
    //cases*case_qty + pieces in pick bin = countQty
    //countQty - qoh = writeQtyIO
    //totalCost = writeQtyIO * item cost
    var newCount = elem.value;
    var counttd = document.getElementById("count_"+itemName);
    var oldCount = document.getElementById("pickCount_"+itemName).innerText;
    writeQtyIO = document.getElementById("writeIO_"+itemName);
    var qoh = document.getElementById("qoh_"+itemName).innerText;
    totalCost = document.getElementById("totalCost_"+itemName);
    //console.log("qoh",qoh);
       //get new pick bin location php update display here
        if (newCount != 0) {
            // countQty = Number(counttd.innerText) + Number(newCount);
            // counttd.innerText = countQty;
            // writeQtyIO.innerText = countQty - Number(qoh);
            // totalCost.innerText = writeQtyIO.innerText * cost;
            
            //update pick bin by calling php
            if(Number(oldCount) === 0) {
                var newBin = prompt("Please enter the pick bin location of this amount");
                if(newBin === "" || newBin == null) {
                    document.getElementById('pickBin').value='';
                }
                else{
                    
                }
               
                jQuery.ajax({
                    type: "POST",
                    url: 'tableDisplay.php',
                    dataType: 'json',
                    data: {functionname: 'addItemToBin', arguments: [item]},
                
                    success: function( msg ) {
                        alert( "Data Saved: " + msg );
                    }
                });
            }
            changeCountFont(writeQtyIO, totalCost);
        }
        
}
function changeDisplayedPalletCount(itemName, elem, piecesPerCase, casesPerPallet, cost){
    var newCount = elem.value;
    var counttd = document.getElementById("count_"+itemName);
    var writeQtyIO = document.getElementById("writeIO_"+itemName);
    var qoh = document.getElementById("qoh_"+itemName).innerText;
    var totalCost = document.getElementById("totalCost_"+itemName);
    if(newCount == 0)
    {
        //remove item from bin in database
        if(confirm("Remove this item from bulk row: ?")){
            console.log("removing item");//removeItemFromBin()
        }
    }
    else
    {
        //update bin qty = pallets*cases*pieces
        // counttd.innerText = Number(counttd.innerText) + Number(newCount)*piecesPerCase*casesPerPallet;
        // writeQtyIO.innerText = Number(counttd.innerText) - Number(qoh);
        // totalCost.innerText = writeQtyIO.innerText * cost;
        //addItemToBin()
    }
    changeCountFont(writeQtyIO, totalCost);
}


function changeDisplayedCaseCount(itemName, elem, piecesPerCase, cost){
    var newCount = elem.value;
    var counttd = document.getElementById("count_"+itemName);
    var writeQtyIO = document.getElementById("writeIO_"+itemName);
    var qoh = document.getElementById("qoh_"+itemName).innerText;
    var totalCost = document.getElementById("totalCost_"+itemName);
    if(Number(newCount) === 0)
    {
        //remove item from bin in database
        if(confirm("Remove this item from bin: ?"))
            console.log("removing item");
    }
    else {
        // counttd.innerText = Number(counttd.innerText) + Number(newCount)*piecesPerCase;
        // writeQtyIO.innerText = Number(counttd.innerText) - Number(qoh);
        // totalCost.innerText = writeQtyIO.innerText * cost;
        //addItemToBin()
    }
    changeCountFont(writeQtyIO, totalCost);
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
   
    function getSelWarehouse() {
        console.log("run");
        return document.getElementById("warehouseSelect").selectedIndex;
    }