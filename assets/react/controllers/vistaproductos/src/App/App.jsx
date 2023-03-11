import React, { useState } from "react";
import "./App.css";
import Productos from './Productos';
import Cabecera from './Cabecera';
import Boton from './BotonPago';


const App = () => {
   
    return (
        <div class="app">
            <Cabecera />
            <Productos />
            <Boton/>
        </div>);
}

export default App;