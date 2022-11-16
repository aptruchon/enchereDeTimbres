export class Filtre {
    constructor(){
        this.iconeFiltre = document.querySelector("[data-js-iconeFiltre]");
        this.iconeCheck = document.querySelector("[data-js-iconeCheck]");
        this.filtre = document.querySelector("[data-js-filtre]");

        this.init();
    }

    init(){

        this.iconeCheck.addEventListener("click", function(){
            this.iconeCheck.classList.add("cache");
            this.iconeFiltre.classList.remove("cache");
            this.filtre.classList.add("cache");
        }.bind(this))

        this.iconeFiltre.addEventListener("click", function(){
            this.iconeFiltre.classList.add("cache");
            this.iconeCheck.classList.remove("cache");
            this.filtre.classList.remove("cache");         
        }.bind(this))
    }
}