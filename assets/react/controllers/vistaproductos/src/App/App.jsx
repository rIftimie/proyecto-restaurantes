import React, { useState } from "react";
import "./App.css";
import DeseoInput from './DeseoInput';
import Cabecera from './Cabecera';
import Boton from './Boton';

const deseosIniciales = [
   
];

const App = () => {
    const [deseos, setDeseos] = useState(deseosIniciales);; // Creamos estado para modificar la lista deseos
    return (
        <div class="app">
            <Cabecera />
            <DeseoInput />
            <Boton/>
        </div>);
}

export default App;