function clickText(){
    alert("Clicked!");
}
function setColor(){
    document.getElementById("div1").style.color = document.getElementById("div1").innerHTML;
}

function toggleVis(){
    $(document).ready(function(){
        $("vis").click(function(){
          $("#div3").hide();
        });
      });
}