function closeDiv() {
    var div = document.getElementById("ttoast");
    div.classList.add("hidden");
    div.addEventListener("transitionend", function() {
        div.parentNode.removeChild(div);
    });
  }