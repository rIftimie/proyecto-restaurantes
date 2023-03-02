import React from "react";
import PropTypes from 'prop-types';
import imagen1 from '../img/nachos.jpg';
import BotonMenos from "../BotonMas";
import BotonMas from "../BotonMenos";

   
const DeseoInput = (props) => {
  const { texto, descripcion } = props;

  const imagenes = Array.from({ length: 4 }, (_, index) => (
    <div key={index}>
      <img src={imagen1} alt="Nachos con queso" width={200}/>
      <h5> {texto} </h5>
      <h6> {descripcion} </h6>
      <BotonMenos/>
      <BotonMas/>
    </div>
  ));

  return <>{imagenes}</>;
}

DeseoInput.propTypes = {
  texto: PropTypes.string.isRequired,
  descripcion: PropTypes.string.isRequired,
}

DeseoInput.defaultProps = {
  texto: 'Nachos con queso.........................................3$',
  descripcion: 'Tortitas de trigo en forma de triangulo con carne picada y queso fresco',
}

export default DeseoInput;
