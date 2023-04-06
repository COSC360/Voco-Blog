window.onload = function () {
    const entryList = document.querySelectoAll(".entry");
    const link = document.querySelector(".blog-link");

    for (let i = 0; i < entryList.length; i++) {
        const element = entryList[i];
    }

    // TODO: FIX LINKS
entry.addEventListener("click", clickentry)


function clickentry(event) {
    console.log(link);
    link.click();

}
}
