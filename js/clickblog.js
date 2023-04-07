window.onload = function () {
    const entryList = document.querySelectorAll(".entry");
    const linkList = document.querySelectorAll(".blog-link");

    for (let i = 0; i < entryList.length; i++) {
        const element = entryList[i];
        const link = linkList[i];
        element.addEventListener("click", function() {
            clickentry(event,link)
        })
    }




function clickentry(event,link) {
    link.click();

}
}
