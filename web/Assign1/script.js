function clickText(){
    alert("Clicked!");
}
function setColor(){
    document.getElementById("div1").style.color = $_Post("setColor");
}

function toggleVis(){
    $(document).ready(function(){
        $("vis").click(function(){
          $("#div3").hide();
        });
      });
}