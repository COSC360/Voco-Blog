window.onload = function () {
    const entryList = document.querySelectorAll(".entry");
    const linkList = document.querySelectorAll(".blog-link");

    for (let i = 0; i < entryList.length; i++) {
        const element = entryList[i];
        const link = linkList[i];
        element.addEventListener("mouseover", function() {
            link.style.color = "blue";
            element.style.cursor = "pointer";
        })
        element.addEventListener("mouseout", function() {
            link.style.color = "black";
            element.style.cursor = "";

        })

        element.addEventListener("click", function() {
            clickentry(event,link)
        })
    }




function clickentry(event,link) {
    link.click();

}
}
