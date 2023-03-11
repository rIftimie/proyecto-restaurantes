import React from "react";
import PropTypes from 'prop-types';
import imagen1 from '../img/nachos.jpg';
import BotonAgregar from "../BotonAgregar";
import BotonQuitar from "../BotonQuitar";

   
const Productos = (props) => {
  const { texto, descripcion } = props;

  const imagenes = Array.from({ length: 4 }, (_, index) => (
    <div key={index}>
      <img src={imagen1} alt="Nachos con queso" width={200}/>
      <h5> {texto} </h5>
      <h6> {descripcion} </h6>
      <BotonAgregar/>
      <BotonQuitar/>
    </div>
  ));

  return <>{imagenes}</>;
}

Productos.propTypes = {
  texto: PropTypes.string.isRequired,
  descripcion: PropTypes.string.isRequired,
}

Productos.defaultProps = {
  texto: 'Nachos con queso.........................................3$',
  descripcion: 'Tortitas de trigo en forma de triangulo con carne picada y queso fresco',
}

export default Productos;