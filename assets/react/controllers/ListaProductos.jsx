import React, { useState } from 'react';
import BotonAgregar from "./BotonAgregar";
import BotonPago from "./BotonPago";
import BotonQuitar from "./BotonQuitar";
import Cabecera from "./Cabecera";
import Productos from "./Productos";
import "./App.css";


const ListaProductos = () => {
    return (
        <div>
            <Cabecera/>
            <Productos/>
            <BotonPago/>
        </div>
    )

}

export default ListaProductos;