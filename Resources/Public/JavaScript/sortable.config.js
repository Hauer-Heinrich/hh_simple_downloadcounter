// Chrome's NodeList forEach Implementation
if(window.NodeList && !NodeList.prototype.forEach){
    NodeList.prototype.forEach = Array.prototype.forEach;
}

document.addEventListener("DOMContentLoaded", function(e) {

    var count = document.querySelectorAll(".count");
    count.forEach(function(element) {
        var reset = element.querySelector(".reset"),
            link = reset.querySelector("a"),
            linkURL = link.getAttribute("href");

        link.addEventListener("click", function(e) {
            e.preventDefault();
            fetch(linkURL, { // DON'T WORK IN IE but in edge!
                method: "POST"
                // body: JSON.stringify(data)
            }).then(res => {
                element.innerHTML = "0";
                console.log("Request complete! response:", res);
            }).catch(error => console.error(error));
        });
    });

});
