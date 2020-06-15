
document.addEventListener('DOMContentLoaded', () => {

    const watchlist = document.getElementById('watchlist');
    watchlist.addEventListener("click", (event)=> {
        event.preventDefault();
        watchlist.classList.toggle('active');
        const link = watchlist.dataset.href;
        fetch(link)
            .then(function (res) {
                return res.text()
            })
            .then(function (json) {
                const response = JSON.parse(json);
            })
    })
})
