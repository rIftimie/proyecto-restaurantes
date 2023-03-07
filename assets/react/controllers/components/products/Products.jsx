import React, { useEffect, useState } from "react";
import PropTypes from 'prop-types';

import { getProducts } from "../../helpers/products";
import ProductsButtons from './ProductsButtons';
   
const Products = ({ idres , idtable , orderProducts , setOrderProducts}) => {
  const [prods, setProds] = useState([])
  useEffect(() => {
    getProds(idres);
  }, [])
  

  const getProds =  async (el)=>{
    const prt=await getProducts(el);
    setProds(prt);
  }
  console.log(prods);

  return (
          <>
            {
              prods.map((prod)=>(
                <> 
                  { prod.stock && !prod.hidden && <div key={prod.id}>
                                                    <img src={prod.product.img} alt={prod.product.name} width={200}/>
                                                    <h5> {prod.product.name} </h5>
                                                    <h6> {prod.product.description} </h6>
                                                    <h3> {prod.product.price}€ </h3>
                                                  </div>}
                </>
              ))
            }
          </>
  );
}

export default Products;
