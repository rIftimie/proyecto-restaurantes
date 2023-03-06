import React, { useState } from 'react';
import BotonAgregar from "../../components/products/AddButon";
import BotonPago from "../../components/stripe/PayButton";
import BotonQuitar from "../../components/DeleteButton";
import Cabecera from "../../components/products/Header";
import Productos from "../../components/products";
import "../App.css";


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