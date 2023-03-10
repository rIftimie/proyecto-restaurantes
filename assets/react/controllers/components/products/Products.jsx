<<<<<<< Updated upstream
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
=======
import React, { useEffect, useState } from "react";
import "../../pages/client/css/Products.css";
import { getProducts } from "../../helpers/products";
import ProductsButtons from "./ProductsButtons";

const Products = ({
  idres,
  idtable,
  orderProducts,
  setOrderProducts,
  setShow,
}) => {
  const [prods, setProds] = useState([]);
  useEffect(() => {
    getProds(idres);
  }, []);

  const getProds = async (el) => {
    const prt = await getProducts(el);
    setProds(prt);
    setShow(true);
  };

  const icons={
    'Gluten':<i class="fa-light fa-wheat"></i>,
    'Lacteos':<i class="fa-light fa-glass"></i>,
    'Frutos Secos':<i class="fa-light fa-peanuts"></i>,
    'Huevos':<i class="fa-light fa-egg"></i>,
}
  console.log(icons);

  return (
    <>
      {prods.map((prod) => (
        <>
          {prod.stock && !prod.hidden && (
            <div key={prod.id} className="row my-5">
              <div className="col-2 mx-2">
                <img
                  src={prod.product.img}
                  alt={prod.product.name}
                  width={200}
                />
              </div>
              <div className="col-9">
                <div className="row">
                  <div className="col-9 border-dotted">
                    <h5> {prod.product.name} </h5>
                  </div>
                  <div className="col border-dotted">
                    <h5 className="text-end"> {prod.product.price}€ </h5>
                  </div>
                </div>
                <h6> {prod.product.description} </h6>
                {prod.product.allergens && (
                  <h6 className="px-2">
                    Alérgenos: {prod.product.allergens.map((all) => icons[all])}
                  </h6>
                )}
                <ProductsButtons
                  idres={idres}
                  idtable={idtable}
                  orderProducts={orderProducts}
                  setOrderProducts={setOrderProducts}
                  idprod={prod.id}
                />
              </div>
            </div>
          )}
        </>
      ))}
    </>
  );
};
>>>>>>> Stashed changes

export default Products;
