import { ValidationMise } from './ValidationMise.js';
import { Filtre } from './Filtre.js';

// Script pour toggle la section filtre
let iconeFiltre = document.querySelector("[data-js-iconeFiltre]");
if(iconeFiltre){
    new Filtre();
}

// Vérification que la mise soit plus basse que la mise actuel et qu'on ne soummette pas de chaines de lettres
new ValidationMise();
