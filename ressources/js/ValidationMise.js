export class ValidationMise {
    constructor(){
        this.miseActuelle = parseInt(document.querySelector("[data-js-mise]").textContent),
        this.inputMise = document.querySelector("[data-js-inputMise]"),
        this.boutonMiser = document.querySelector("[data-js-bouton]"),
        this.messageErreur = document.querySelector("[data-js-message]"),
        this.messageErreurType = document.querySelector("[data-js-messageType]"),
        this.numbers = /^[0-9]+$/;

        this.init();
    }

    init(){
        this.inputMise.addEventListener("input", function(){
            this.mise = this.inputMise.value;
            this.inputMise.classList.remove("fiche_champs-mise-erreur");
        }.bind(this))
        
        this.boutonMiser.addEventListener("keypress", function(e){
            if(e.key === "Enter"){
                console.log("enter");
                
                if(this.mise.match(this.numbers)){
                    if(parseInt(this.mise) <= miseActuelle || parseInt(this.mise) == ""){
                        e.preventDefault();
                        this.inputMise.classList.add("fiche_champs-mise-erreur");
                        this.messageErreurType.classList.add("messageCache");
                        this.messageErreur.classList.remove("messageCache");
                    }
                }
                else {
                    e.preventDefault();
                    this.inputMise.classList.add("fiche_champs-mise-erreur");
                    this.messageErreur.classList.add("messageCache");
                    this.messageErreurType.classList.remove("messageCache");
                }
            }
        }.bind(this))
        
        this.boutonMiser.addEventListener("click", function(e){
            console.log("click");
            if(this.mise.match(this.numbers)){
                if(parseInt(this.mise) <= this.miseActuelle || parseInt(this.mise) == ""){
                    e.preventDefault();
                    this.inputMise.classList.add("fiche_champs-mise-erreur");
                    this.messageErreurType.classList.add("messageCache");
                    this.messageErreur.classList.remove("messageCache");
                }
            }
            else {
                e.preventDefault();
                this.inputMise.classList.add("fiche_champs-mise-erreur");
                this.messageErreur.classList.add("messageCache");
                this.messageErreurType.classList.remove("messageCache");
            }
        }.bind(this))
    }
}
