document.addEventListener("DOMContentLoaded", function () {
    let marque = document.querySelector('#marque');
    if(marque){
        marque.addEventListener('blur', afficher);
    }

    const listEl = document.getElementById('inserthere');


    function afficher(){
        let choix = document.querySelector('#marque').value;
        let ul = document.querySelector('#inserthere');
       console.log("Données entrées : " + choix);
       if(choix!=''){
           let c = ' ';
           fetch('./lib/JSON/marques.json')
               .then(data => data.json())
               .then(function (data) {
                   data.forEach(post => {
                       if(post.marque.toUpperCase() == choix.toUpperCase()){
                           ul.insertAdjacentHTML('beforeend',`<li class="list-group-item">${post.marque}<br>Type : ${post.type}
                                 <br>Poids : ${post.poids} <br> Goût : ${post.gout} <br> Prix : ${post.prix} € </li>`)
                       }
                   })


               });



       }
    }
}
)