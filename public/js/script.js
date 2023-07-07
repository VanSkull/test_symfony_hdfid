window.addEventListener("load", function(){
    let headerHeight = document.querySelector('header').offsetHeight;
    console.log(headerHeight);
    document.body.style.paddingTop = headerHeight+"px";
});
window.addEventListener("resize", function(){
    let headerHeight = document.querySelector('header').offsetHeight;
    console.log(headerHeight);
    document.body.style.paddingTop = headerHeight+"px";
});

function filterMovies(){
    let titleMovie = document.querySelector('input[name="title-movie"]').value;
    let yearMovie = document.querySelector('input[name="year-movie"]').value;
    let genreMovie = document.querySelector('select[name="genre-movie"]').value;

    // console.log(titleMovie + " + " + yearMovie + " + " + genreMovie);

    if (titleMovie == "" && yearMovie == "" && genreMovie == "") {
        return;
    }

    let queryRequest = "";
    if (titleMovie) {
        queryRequest += "titleMovie="+titleMovie+"&";
    }
    if (yearMovie) {
        queryRequest += "year="+yearMovie+"&";
    }
    if (genreMovie) {
        queryRequest += "genre="+genreMovie+"";
    }

    document.location.href = "/movies?"+queryRequest;
}

function filterActors(){
    let nameActor = document.querySelector('input[name="name-actor"]').value;
    
    // console.log(nameActor);
    
    if (nameActor) {
        alert("La fonctionnalité de filtrage par nom des acteurs n'est pas encore intégrée à l'API. Mais ça ne saurait tarder !!!");
        // document.location.href = "/actors?nameActor="+nameActor;
    }
}