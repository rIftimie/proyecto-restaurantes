import React from "react";
import PropTypes from 'prop-types';
import ProductsButtons from './ProductsButtons';
   
const Products = (props) => {
  const { texto, descripcion } = props;

  const imagenes = Array.from({ length: 4 }, (_, index) => (
    <div key={index}>
      <img src='' alt="Nachos con queso" width={200}/>
      <h5> {texto} </h5>
      <h6> {descripcion} </h6>
      <ProductsButtons/>
    </div>
  ));

  return <>{imagenes}</>;
}

Products.propTypes = {
  texto: PropTypes.string.isRequired,
  descripcion: PropTypes.string.isRequired,
}

Products.defaultProps = {
  texto: 'Nachos con queso.........................................3$',
  descripcion: 'Tortitas de trigo en forma de triangulo con carne picada y queso fresco',
}

export default Products;
