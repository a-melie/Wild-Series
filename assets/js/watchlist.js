
document.addEventListener('DOMContentLoaded', () => {

    const watchlist = document.getElementsByClassName('watchlist');
    for ( let i = 0; i<watchlist.length; i++){
        watchlist[i].addEventListener("click", (event)=> {
            event.preventDefault();
            watchlist[i].classList.toggle('active');
            const link = watchlist[i].dataset.href;
            fetch(link)
                .then(function (res) {
                    return res.text()
                })
                .then(function (json) {
                    const response = JSON.parse(json);
                })
        })
    }

})
