import React, { useState } from "react";
import "./App.css";
import DeseoInput from './Productos';
import Cabecera from './Cabecera';
import Boton from './BotonPago';

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